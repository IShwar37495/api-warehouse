<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{



    public function dashboard(Request $request):Response{

      return Inertia::render('Dashboard');


    }
    public function addProfilePic(Request $request):RedirectResponse
    {
        $user = auth()->user();

        if (!$request->hasFile('photo')) {
            return back()->with('error', 'No image uploaded');
        }

        try {
            $uploaded_image = $request->file("photo");
            $uploadedImage = Cloudinary::upload($uploaded_image->getRealPath())->getSecurePath();

            $user->profile_photo_path = $uploadedImage;
            $user->save();

            return redirect()->back()->with([
                'success' => 'Profile picture uploaded successfully',
                'profile_photo_url' => $uploadedImage
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to upload image: ' . $e->getMessage());
        }
    }

public function showChatPage():Response{
   return Inertia::render("Chat");
}


public function sendAccessToken(Request $request)
{
    $accessToken = $request->cookie('access_token');
    if ($accessToken) {
        return ApiResponse::success($accessToken, 200);
    }
    $refreshToken = $request->cookie('refresh_token');

    if (!$refreshToken) {
        return ApiResponse::error('Unauthorized Access', 401);
    }

    try {

        $decoded = JWT::decode($refreshToken, new Key(env('JWT_SECRET'), 'HS256'));

        if ($decoded->exp < Carbon::now()->timestamp) {
            return ApiResponse::error('Refresh token has expired', 401);
        }

        $user_id = $decoded->sub;
        $token = DB::table('refresh_tokens')
            ->where('token', $refreshToken)
            ->where('user_id', $user_id)
            ->first();

        if (!$token) {
            return ApiResponse::error('Invalid refresh token', 401);
        }
        DB::table('refresh_tokens')->where('id', $token->id)->delete();
        $user = User::find($user_id);

        if (!$user) {
            return ApiResponse::error('User not found', 404);
        }
        $newAccessToken = $user->generateAccessToken($user->id);
        $newRefreshToken = $user->generateRefreshToken($user->id);


        Cookie::queue(
            'access_token',
            $newAccessToken,
            15,
            '/',
            null,
            true,
            true
        );


        Cookie::queue(
            'refresh_token',
            $newRefreshToken,
            7 * 24 * 60,
            '/',
            null,
            true,
            true
        );

        return ApiResponse::success([
            'access_token' => $newAccessToken
        ]);
    } catch (\Exception $e) {
        return ApiResponse::error('Invalid refresh token', 401);
    }
}


public function SearchUsers(Request $request)
{
    $query = $request->input('query');

    $users = User::where('name', 'like', "%{$query}%")
                 ->orWhere('email', 'like', "%{$query}%")
                 ->get();

    return response()->json($users);
}

}
