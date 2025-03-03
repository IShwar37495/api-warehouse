<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApiPageController extends Controller
{
    public function allcountriesApiPageDemo(){

        try{

            return Inertia::render("ApiPages/Countries");

        }catch(Exception $e){
            return ApiResponse::error("Something went wrong on our side Please try again later", 500, ['error'=>$e->getMessage()]);

        }
    }
}
