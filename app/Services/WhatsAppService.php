<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $baseUrl;
    protected $apiKey;
    protected $session;
    protected $timeout;

    public function __construct()
    {
        $this->baseUrl = rtrim(env('WAHA_BASE_URL'), '/');
        $this->apiKey = env('WAHA_API_KEY');
        $this->session = env('WAHA_SESSION', 'default');
        // Timeout lebih pendek untuk mencegah 504 di staging (default 10 detik)
        $this->timeout = env('WAHA_TIMEOUT', 10);
    }

    /**
     * Kirim pesan teks ke WhatsApp
     */
    public function sendMessage($phoneNumber, $message)
    {
        try {
            // Format nomor WhatsApp (tambahkan @c.us jika belum ada)
            $chatId = $this->formatPhoneNumber($phoneNumber);

            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'X-Api-Key' => $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post("{$this->baseUrl}/api/sendText", [
                    'session' => $this->session,
                    'chatId' => $chatId,
                    'text' => $message,
                ]);

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully', [
                    'phone' => $phoneNumber,
                    'response' => $response->json()
                ]);
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            Log::error('Failed to send WhatsApp message', [
                'phone' => $phoneNumber,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return [
                'success' => false,
                'error' => 'Failed to send message: ' . $response->body()
            ];

        } catch (\Exception $e) {
            Log::error('WhatsApp service exception', [
                'phone' => $phoneNumber,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Kirim gambar dengan caption ke WhatsApp
     */
    public function sendImage($phoneNumber, $imageUrl, $caption = '')
    {
        try {
            $chatId = $this->formatPhoneNumber($phoneNumber);

            // Pastikan URL gambar adalah URL lengkap
            if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                $imageUrl = url($imageUrl);
            }

            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'X-Api-Key' => $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post("{$this->baseUrl}/api/sendImage", [
                    'session' => $this->session,
                    'chatId' => $chatId,
                    'file' => [
                        'url' => $imageUrl,
                    ],
                    'caption' => $caption,
                ]);

            if ($response->successful()) {
                Log::info('WhatsApp image sent successfully', [
                    'phone' => $phoneNumber,
                    'imageUrl' => $imageUrl
                ]);
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            Log::error('Failed to send WhatsApp image', [
                'phone' => $phoneNumber,
                'imageUrl' => $imageUrl,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return [
                'success' => false,
                'error' => 'Failed to send image: ' . $response->body()
            ];

        } catch (\Exception $e) {
            Log::error('WhatsApp send image exception', [
                'phone' => $phoneNumber,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Format nomor telepon ke format WhatsApp
     * Contoh: 081234567890 -> 6281234567890@c.us
     */
    protected function formatPhoneNumber($phoneNumber)
    {
        // Hilangkan semua karakter non-digit
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Jika dimulai dengan 0, ganti dengan 62
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }

        // Jika belum ada kode negara, tambahkan 62
        if (substr($phoneNumber, 0, 2) !== '62') {
            $phoneNumber = '62' . $phoneNumber;
        }

        // Tambahkan @c.us jika belum ada
        if (strpos($phoneNumber, '@c.us') === false) {
            $phoneNumber = $phoneNumber . '@c.us';
        }

        return $phoneNumber;
    }

    /**
     * Cek status session WAHA
     */
    public function getSessionStatus()
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'X-Api-Key' => $this->apiKey,
                ])
                ->get("{$this->baseUrl}/api/sessions/{$this->session}");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'error' => 'Failed to get session status'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}