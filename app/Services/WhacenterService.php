<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhacenterService
{
    protected string $to;
    protected string $message = '';
    protected string $baseUrl = '';
    protected string $deviceId = '';

    public function __construct($message = '')
    {
        $this->message = $message;
        $this->baseUrl = 'https://app.whacenter.com/api';
        $this->deviceId = env('WHACENTER_DEVICE_ID');
    }

    public function getDeviceStatus(): mixed
    {
        return Http::get($this->baseUrl . '/statusDevice?device_id=' . $this->deviceId);
    }

    public function message($message = ''): self
    {
        $this->message = $message;

        return $this;
    }

    public function to($to): self
    {
        $this->to = $to;

        return $this;
    }

    public function send(): mixed
    {
        if($this->to == '' || $this->message == ''){
            throw new \Exception('Invalid message format: "to" address and "message" of the message must not be empty.');
        }

        $payload = [
            'device_id' => $this->deviceId,
            'number' => $this->to,
            'message' => $this->message
        ];

        try {
            $response = Http::post($this->baseUrl . '/send', $payload);
            return $response->body();
        } catch (\Throwable $th) {
            // Log the error for further investigation
            Log::error('Failed to send message via Whacenter: ' . $th->getMessage());
            throw $th;  // or handle it more gracefully
        }
    }
}