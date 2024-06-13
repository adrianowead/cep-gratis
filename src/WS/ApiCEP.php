<?php

namespace Wead\ZipCode\WS;

use Wead\ZipCode\Contracts\ProviderContract;

class ApiCEP extends ProviderContract
{
    public function getAddressFromZipcode($zipCode)
    {
        $zipCode = preg_replace('/[^0-9]/im', '', $zipCode);

        $endPoint = "https://ws.apicep.com/cep/{$zipCode}.json";

        $content = file_get_contents($endPoint);

        $response = json_decode($content);

        return $this->normalizeResponse((array)$response);
    }

    private function normalizeResponse($address)
    {
        if (sizeof($address) > 0 && strlen($address['address']) > 0) {
            return [
                "status" => true,
                "address" => $address["address"],
                "district" => $address["district"],
                "city" => $address["city"],
                "state" => $address["state"],
                "api" => "ApiCEP"
            ];
        } else {
            return [
                "status" => false,
                "address" => null,
                "district" => null,
                "city" => null,
                "state" => null,
                "api" => "ApiCEP"
            ];
        }
    }
}
