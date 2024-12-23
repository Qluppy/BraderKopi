<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FonnteService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('FONNTE_API_KEY', 'your-fonnte-api-key');
    }

    public function sendMessage($to, $message)
    {
        $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
        ])->post('https://api.fonnte.com/send', [
            'target' => $to,
            'message' => $message,
            'countryCode' => '62',
        ]);

        // Debug respons API
        if ($response->failed()) {
            dd("Error Fonnte: ", $response->body()); // Tambahkan untuk debugging
        }

        return $response->json();
    }
}
