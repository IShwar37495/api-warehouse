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
}
