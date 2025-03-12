<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

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
}
