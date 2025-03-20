<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        // Log incoming request
        Log::info('Incoming chatbot request:', $request->all());

        $userMessage = $request->input('message');

        // Log the user's message
        Log::info('User message:', ['message' => $userMessage]);

        try {
            // Send request to Hugging Face API
            $response = Http::timeout(30) // Increase timeout
                ->withHeaders([
                    'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_KEY'), // API Key from .env
                    'Content-Type' => 'application/json',
                ])->post('https://api-inference.huggingface.co/models/facebook/blenderbot-400M-distill', [
                    'inputs' => $userMessage,
                ]);

            // Log API response
            Log::info('Hugging Face API response:', $response->json());

            // Check for errors
            if ($response->successful() && isset($response->json()[0]['generated_text'])) {
                $aiReply = $response->json()[0]['generated_text'];

                return response()->json(['reply' => $aiReply]);
            } else {
                // Log the error if the response is not successful
                Log::error('Hugging Face API error:', ['status' => $response->status(), 'body' => $response->body()]);
                return response()->json(['reply' => 'Error: Unable to process your request.'], 500);
            }
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Exception occurred:', ['error' => $e->getMessage()]);
            return response()->json(['reply' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
