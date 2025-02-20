<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Api;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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


}
