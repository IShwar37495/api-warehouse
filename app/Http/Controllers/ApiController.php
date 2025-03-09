<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Api;
use App\Models\ClientUser;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ApiController extends Controller
{
    public function allApis(): JsonResponse{

      try{
        $apis=Api::paginate(10);

        return ApiResponse::success([

            'apis'=>$apis->items(),
            'paginattion'=>[
                'total'=>$apis->total(),
                'per_page'=>$apis->perPage(),
                'current_page'=>$apis->currentPage(),
                'last_page'=>$apis->lastPage(),
                'next_page_url' => $apis->nextPageUrl(),
                'prev_page_url' => $apis->previousPageUrl(),
            ]
            ],"Api's fetched successfully", 200);
      }catch(Exception $e){
        return ApiResponse::error("Failed to Fetch Api's", 500, ['error'=>$e->getMessage()]);
      }



    }

public function indianStates(Request $request)
    {
        try {
            $states = [
                "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh",
                "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jharkhand", "Karnataka",
                "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur", "Meghalaya", "Mizoram",
                "Nagaland", "Odisha", "Punjab", "Rajasthan", "Sikkim", "Tamil Nadu",
                "Telangana", "Tripura", "Uttar Pradesh", "Uttarakhand", "West Bengal"
            ];

            return ApiResponse::success($states, "List of Indian States");

        } catch (Exception $e) {
            return ApiResponse::error("Something went wrong", 500, ['error' => $e->getMessage()]);
        }
    }



    // Api for fetching all countries


    public function allCountries(){

        try{
            $response=Http::get('https://restcountries.com/v3.1/all');
            $countries=$response->json();

                    $formattedCountries = collect($countries)->map(function ($country) {
                    return [
                        'name' => $country['name']['common'],
                        'official_name' => $country['name']['official'],
                        'code' => $country['cca2'] ?? null,
                        'alpha3_code' => $country['cca3'] ?? null,
                        'capital' => $country['capital'][0] ?? null,
                        'region' => $country['region'] ?? null,
                        'subregion' => $country['subregion'] ?? null,
                        'population' => $country['population'] ?? null,
                        'flag' => $country['flags']['png'] ?? null,
                    ];
                })->sortBy('name')->values()->all();


                return ApiResponse::success($formattedCountries, "List of countries fetched successfully", 200);

        }catch(Exception $e){
            return ApiResponse::error("Failed to fetch countries", 500, ['error'=>$e->getMessage()]);
        }
    }

public function registerUser(Request $request)
{

        $clientId = $request->header('Client-ID');

        if (!$clientId) {
            return ApiResponse::error('Client ID is missing', 400);
        }

        $validClient=User::where('client_id',$clientId)->first();
        if(!$validClient){
            return ApiResponse::error('Invalid Client ID', 400);
        }

    try {
        // Validate request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:client_users,email',
            'password' => 'required|min:6',
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'age' => 'nullable|integer|max:110'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation Error', 422, $validator->errors());
        }

        // Check if the user already exists for the given client
        $existingUser = ClientUser::where('client_id', $clientId)
            ->where('email', $request->email)
            ->first();

        if ($existingUser) {
            return ApiResponse::error('User already exists', 409);
        }

        // Create user
        $user = ClientUser::create([
            'client_id' => $clientId,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name ?? null,
            'phone' => $request->phone ?? null,
            'address' => $request->address ?? null,
            'company' => $request->company ?? null,
            'age' => $request->age ?? null,
        ]);

        // Generate JWT Access & Refresh Tokens
        $accessToken = $user->generateAccessToken($user->id);
        $refreshToken = $user->generateRefreshToken($user->id);

        // Store tokens in the database
        $user->update([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ]);

        // Prepare response data
     $data = [
    'user' => $user->makeHidden(['password', 'client_id']),
];

         return ApiResponse::success($data, 'User registered successfully', 201);

    } catch (Exception $e) {
        return ApiResponse::error('Failed to register user, something went wrong on our side', 500, ['error' => $e->getMessage()]);
    }
}

public function loginUser(Request $request)
{

      $clientId = $request->header('Client-ID');

        if (!$clientId) {
            return ApiResponse::error('Client ID is missing', 400);
        }

           $validClient=User::where('client_id',$clientId)->first();
        if(!$validClient){
            return ApiResponse::error('Invalid Client ID', 400);
        }
    try {
        // Validate request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation Error', 422, $validator->errors());
        }

        // Find user by email and client_id
        $user = ClientUser::where('client_id', $clientId)
            ->where('email', $request->email)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ApiResponse::error('Invalid credentials', 401);
        }

        // Generate JWT Access & Refresh Tokens
        $accessToken = $user->generateAccessToken($user->id);
        $refreshToken = $user->generateRefreshToken($user->id);

        // Store tokens in the database
        $user->update([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ]);

            $data = [
    'user' => $user->makeHidden(['password', 'client_id',])

];
   return ApiResponse::success($data, 'User Logged in successfully', 200);

    } catch (Exception $e) {
        return ApiResponse::error('Login failed, something went wrong', 500, ['error' => $e->getMessage()]);
    }
}

public function refreshToken(Request $request)
{
    try {
        // Get refresh token from the HTTP-only cookie
        $refreshToken = $request->header('Refresh-Token');

        if (!$refreshToken) {
            return ApiResponse::error('Refresh token is missing', 401);
        }

        // Decode & Validate JWT refresh token
        try {
            $decoded = JWT::decode($refreshToken, new Key(env('JWT_SECRET'), 'HS256'));
        } catch (\Firebase\JWT\ExpiredException $e) {
            return ApiResponse::error('Refresh token expired', 401);
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            return ApiResponse::error('Invalid refresh token', 401);
        } catch (Exception $e) {
            return ApiResponse::error('Could not verify refresh token', 401);
        }

        // Extract user ID from the decoded token
        $userId = $decoded->sub; // 'sub' contains the user ID

        // Find user
        $user = ClientUser::find($userId);
        if (!$user || $user->refresh_token !== $refreshToken) {
            return ApiResponse::error('Refresh token is invalid', 401);
        }

        // Generate new Access & Refresh Tokens
        $newAccessToken = $user->generateAccessToken($user->id);
        $newRefreshToken = $user->generateRefreshToken($user->id);


        $user->update([
            'access_token' => $newAccessToken,
            'refresh_token' => $newRefreshToken,
        ]);

        $data=['access_token'=>$newAccessToken, 'refresh_token'=>$newRefreshToken];

        return ApiResponse::success($data, 'Token refreshed successfully', 200);

    } catch (Exception $e) {
        return ApiResponse::error('Failed to refresh token', 500, ['error' => $e->getMessage()]);
    }
}


public function validateToken(Request $request){
    $token = $request->header('Access-Token'); // Get the token from the Authorization header

    if (!$token) {
        return response()->json(['valid' => false, 'message' => 'No token provided'], 401);
    }

    try {
        // Decode the token
        $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));


        $user=ClientUser::find($decoded->sub); // Assuming `sub` contains user ID

        if (!$user) {
            return ApiResponse::error('User not found', 404);
        }

        return ApiResponse::success(['valid' => true, 'message' => 'Token is valid'], 'Token is valid', 200);

    } catch (Exception $e) {
        return response()->json(['valid' => false, 'message' => 'Invalid token'], 401);
    }
}


}
