<?php

namespace App\Services;

use Spatie\Dropbox\TokenProvider;
use Illuminate\Support\Facades\Cache;

class DropboxTokenProvider implements TokenProvider
{
    public function getToken(): string
    {
        // Ambil access token dari cache atau environment
        $accessToken = Cache::get('dropbox_access_token') ?? env('DROPBOX_ACCESS_TOKEN');

        // Jika token sudah kadaluarsa, perbarui token
        if ($this->isTokenExpired($accessToken)) {
            $accessToken = $this->refreshAccessToken();
            $this->saveTokenToCache($accessToken); // Simpan token baru ke cache
        }

        return $accessToken;
    }

    // Mengecek apakah token kedaluwarsa
    private function isTokenExpired(string $accessToken): bool
    {
        // Ambil waktu penyimpanan token dari cache
        $tokenTimestamp = Cache::get('dropbox_access_token_timestamp');

        if (!$tokenTimestamp) {
            return true; // Jika tidak ada timestamp, anggap token kedaluwarsa
        }

        // Hitung waktu yang telah berlalu
        $elapsedTime = time() - $tokenTimestamp;

        // Dropbox token biasanya berlaku 4 jam (14400 detik)
        return $elapsedTime >= 14400; // Jika lebih dari 4 jam, token dianggap kedaluwarsa
    }

    // Menggunakan refresh token untuk mendapatkan access token baru
    private function refreshAccessToken(): string
    {
        $refreshToken = env('DROPBOX_REFRESH_TOKEN');
        $clientId = env('DROPBOX_CLIENT_ID');
        $clientSecret = env('DROPBOX_CLIENT_SECRET');

        // Gunakan Guzzle untuk permintaan ke Dropbox API
        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->post('https://api.dropbox.com/oauth2/token', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                ],
                'verify' => false,
            ]);

            $data = json_decode($response->getBody(), true);
            return $data['access_token']; // Ambil access token baru dari respons
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to refresh access token: ' . $e->getMessage());
        }
    }

    // Menyimpan token ke cache atau storage
    private function saveTokenToCache(string $newAccessToken): void
    {
        // Simpan token ke cache dengan masa berlaku 4 jam
        Cache::put('dropbox_access_token', $newAccessToken, 14400);

        // Simpan timestamp saat token diperoleh
        Cache::put('dropbox_access_token_timestamp', time(), 14400);
    }
}
