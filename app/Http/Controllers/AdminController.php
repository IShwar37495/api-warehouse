<?php

namespace App\Http\Controllers;

use App\Models\Api;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function createApi(): Response {
        try {
            return Inertia::render('admin/createApi');
        } catch (\Exception $e) {
            Log::error('Error loading Create API page: ' . $e->getMessage());

            return Inertia::render('Error', [
                'message' => 'Something went wrong while loading the page.'
            ]);
        }
    }

    public function storeApi(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'endpoint' => 'required|string|unique:apis,endpoint',
            'method' => 'required|in:GET,POST,PUT,PATCH,DELETE',
            'authentication' => 'required|in:None,API Key,Bearer Token,OAuth2,Basic Auth',
            'query_parameters' => 'nullable|json',
            'headers' => 'nullable|json',
            'path_parameters' => 'nullable|json',
            'request_body' => 'nullable|json',
            'response' => 'required|json',
        ]);
        $api = Api::create($validated);

        return response()->json([
            'message' => 'API created successfully!',
            'data' => $api
        ], 201);
    }

}
