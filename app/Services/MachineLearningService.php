<?php

namespace App\Services;

use GuzzleHttp\Client;

class MachineLearningService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://127.0.0.1:5000', // Endereço local da API Python
        ]);
    }

    public function predictGrowth(array $features)
    {
        try {
            $response = $this->client->post('/analyze', [
                'json' => [
                    'features' => $features,
                ],
            ]);

            $data = json_decode($response->getBody());
            return $data;
        } catch (\Exception $e) {
            return $e; 
        }
    }
}