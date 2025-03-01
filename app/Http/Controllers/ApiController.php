<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Api;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

}
