<?php

namespace Wead\ZipCode\WS;

use GuzzleHttp\Client;
use Wead\ZipCode\Contracts\ProviderContract;

class Correios extends ProviderContract
{
    private $endPoint = "https://buscacepinter.correios.com.br/app/endereco/carrega-cep-endereco.php";

    public function getAddressFromZipcode($zipCode)
    {
        $zipCode = preg_replace('/[^0-9]/im', '', $zipCode);

        $headers = [
            "Accept" => "application/json",
        ];

        $client = new Client(['base_uri' => $this->endPoint]);

        $response = $client->post(
            '',
            [
                'headers' => $headers,
                'connect_timeout' => 5,
                'query' => [
                    'endereco' => $zipCode,
                    'tipoCEP' => 'ALL',
                ],
                'debug' => false
            ]
        );

        $response = $response->getBody()->getContents();
        $response = json_decode($response);

        return $this->normalizeResponse((array)$response);
    }

    private function normalizeResponse($address)
    {
        var_dump($address);
        exit;
    }
}