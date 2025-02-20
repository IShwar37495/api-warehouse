<?php
namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse{



    public static function success($data=[],$message="Success", int $statusCode=200):JsonResponse{

        return response()->json([
            'success'=>true,
            'status_code'=>$statusCode,
            'message'=>$message,
            'data'=>$data
        ], $statusCode);
    }

     public static function error(string $message = "Error", int $statusCode = 400, $errors = []): JsonResponse
    {
        return response()->json([
            'success' => false,
            'statusCode' => $statusCode,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }
}
