<?php

namespace Wead\ZipCode\WS;

use GuzzleHttp\Client;

class WideNet
{
    private $endPoint = "http://apps.widenet.com.br/busca-cep/api/cep.json";
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
        $zipCode = preg_replace('/[^0-9]/im', '', $zipCode);

        $headers = [
            "Accept" => "application/json",
        ];

        $client = new Client(['base_uri' => $this->endPoint]);

        try {
            $response = $client->get(
                '',
                [
                    'headers' => $headers,
                    'connect_timeout' => 5, // seconds
                    'query' => [
                        'code' => $zipCode
                    ],
                    'debug' => false
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
        if (sizeof($address) > 0 && $address['status'] == 1) {
            return [
                "status" => true,
                "address" => $address["address"],
                "district" => $address["district"],
                "city" => $address["city"],
                "state" => $address["state"],
                "api" => "WideNet"
            ];
        } else {
            return [
                "status" => false,
                "address" => null,
                "district" => null,
                "city" => null,
                "state" => null,
                "api" => "WideNet"
            ];
        }
    }
}
