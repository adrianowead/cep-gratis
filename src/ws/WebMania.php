<?php

namespace Wead\ZipCode\WS;

use GuzzleHttp\Client;

class WebMania
{
    private $endPoint = "https://webmaniabr.com/api/1/cep";
    private $apiKey = null;
    private $apiSecret = null;

    public function __construct($credential = [])
    {
        if (is_array($credential)) {
            if (isset($credential['apiKey']) && isset($credential['apiSecret'])) {
                $this->apiKey = $credential['apiKey'];
                $this->apiSecret = $credential['apiSecret'];
            }
        }
    }

    public function getAddressFromZipcode($zipCode)
    {
        if (!$this->apiKey) {
            return $this->normalizeResponse([]);
        }

        $zipCode = preg_replace('/[^0-9]/im', '', $zipCode);

        $headers = [
            "Accept" => "application/json",
        ];

        $client = new Client(['base_uri' => "{$this->endPoint}/{$zipCode}/"]);

        try {
            $response = $client->get(
                '',
                [
                'headers' => $headers,
                'connect_timeout' => 5, // seconds
                'query' => [
                    'app_key' => $this->apiKey,
                    'app_secret' => $this->apiSecret,
                ],
                'debug' => false,
                ]
            );
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            throw new \Exception("WebMania request error: {$e->getResponse()->getBody()->getContents()}");
        }

        $response = $response->getBody()->getContents();
        $response = json_decode($response);

        return $this->normalizeResponse((array)$response);
    }

    private function normalizeResponse($address)
    {
        if (sizeof($address) > 0 && !isset($address["error"])) {
            return [
                "status" => true,
                "address" => $address["endereco"],
                "district" => $address["bairro"],
                "city" => $address["cidade"],
                "state" => $address["uf"],
                "api" => "WebMania"
            ];
        } else {
            return [
                "status" => false,
                "address" => null,
                "district" => null,
                "city" => null,
                "state" => null,
                "api" => "WebMania"
            ];
        }
    }
}
