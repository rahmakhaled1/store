<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    private $apiKey;

    protected $baseUrl = 'http://apilayer.net/api/live';

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function convert(string $from, string $to, float $amount = 1): float
    {
        $response = Http::get($this->baseUrl, [
            'access_key' => $this->apiKey,
            'currencies' => $to,
            'source' => $from,
            'format' => 1,
        ]);

        $result = $response->json();
        $rate = $result['quotes']["{$from}{$to}"];

        return $rate * $amount;
    }

}
