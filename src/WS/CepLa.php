<?php

namespace Wead\ZipCode\WS;

use GuzzleHttp\Client;
use Wead\ZipCode\Contracts\ProviderContract;

class CepLa extends ProviderContract
{
    private $endPoint = "http://cep.la";

    public function getAddressFromZipcode($zipCode)
    {
        $zipCode = preg_replace('/[^0-9]/im', '', $zipCode);

        $headers = [
            "Accept" => "application/json",
        ];

        $client = new Client(['base_uri' => "{$this->endPoint}/{$zipCode}"]);

        $response = $client->get(
            '',
            [
                'headers' => $headers,
                'connect_timeout' => 5, // seconds
                'debug' => false,
                ]
        );

        $response = $response->getBody()->getContents();
        $response = json_decode($response);

        return $this->normalizeResponse((array)$response);
    }

    private function normalizeResponse($address)
    {
        if (sizeof($address) > 0) {
            return [
                "status" => true,
                "address" => $address["logradouro"],
                "district" => $address["bairro"],
                "city" => $address["cidade"],
                "state" => $address["uf"],
                "api" => "CepLa"
            ];
        } else {
            return [
                "status" => false,
                "address" => null,
                "district" => null,
                "city" => null,
                "state" => null,
                "api" => "CepLa"
            ];
        }
    }
}