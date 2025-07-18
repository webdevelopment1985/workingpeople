<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogApiRequests
{
    public function handle(Request $request, Closure $next)
    {
        // Log request details
        Log::info('API Request', [
            'method' => $request->getMethod(),
            'url' => $request->fullUrl(),
            'headers' => $request->headers->all(),
            'body' => $request->all(),
            'ip_address' => $request->ip()
        ]);


        $validApiKey = env('ACCESS_API_KEY');

        // Check if the header contains 'x-api-key'
        $apiKey = $request->header('x-api-key');

        if (!$apiKey || $apiKey !== $validApiKey) {
            return response()->json(['message' => 'Unauthorized: Invalid API key'], 401);
        }



        // Log request details
        // Log::info('API Request', [
        //     'method' => $request->getMethod(),
        //     'url' => $request->fullUrl(),
        //     'headers' => $request->headers->all(),
        //     'body' => $request->all(),
        //     'ip_address' => $request->ip()
        // ]);

        // Proceed with the request
        $response = $next($request);

        // Log response details
        Log::info('API Response', [
            'status_code' => $response->getStatusCode(),
            'body' => $response->getContent()
        ]);

        return $response;
    }
}
