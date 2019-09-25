<?php
/**
 * Classe principal para as buscas de CEP
 *
 * Recebe o cep a ser procurado e randomicamente consulta os serviços
 * online, retorna o resultado do primeiro que encontrar
 *
 * @author  Adriano Maciel <adriano_mail@hotmail.com>
 * @license https://opensource.org/licenses/MIT MIT Licence
 */

namespace Wead\ZipCode;

use Wead\ZipCode\WS\CepLa;
use Wead\ZipCode\WS\ViaCep;
use Wead\ZipCode\WS\WideNet;
use Wead\ZipCode\WS\WebMania;

class Search
{
    private $listApiTest = [
        'getFromViaCep',
        'getFromWebMania',
        'getFromWideNet',
        'getFromCepLa',
    ];

    private $credential = [
        'WebMania' => [
            'apiKey' => null,
            'apiSecret' => null
        ]
    ];

    public function setCredential($service, $credential = [])
    {
        if (is_string($service) && is_array($credential)) {
            $this->credential[$service] = $credential;
        }
    }

    public function getAddressFromZipcode($zipCode)
    {
        $found = false;
        $errors = [];

        // shuffle to not exceed api limits
        shuffle($this->listApiTest);

        foreach ($this->listApiTest as $f) {
            if (!$found) {
                try {
                    $found = call_user_func([__CLASS__, $f], $zipCode);
                } catch (\Exception $e) {
                    $errors[$f] = $e->getMessage();

                    if (sizeof($errors) >= sizeof($this->listApiTest)) {
                        $msg = "";

                        foreach ($errors as $i => $m) {
                            $msg .= "[{$i}]: {$m}" . PHP_EOL . PHP_EOL;
                        }

                        throw new \Exception(
                            "Error to get address by zipcode: " .
                            PHP_EOL .
                            $msg
                        );
                    }
                }
            }
        }

        return $found;
    }

    private function getFromViaCep($zipCode)
    {
        $zip = new ViaCep($this->credential);
        $zip = $zip->getAddressFromZipcode($zipCode);

        return $zip;
    }

    private function getFromWebMania($zipCode)
    {
        $zip = new WebMania($this->credential);
        $zip = $zip->getAddressFromZipcode($zipCode);

        return $zip;
    }

    private function getFromWideNet($zipCode)
    {
        $zip = new WideNet($this->credential);
        $zip = $zip->getAddressFromZipcode($zipCode);

        return $zip;
    }

    private function getFromCepLa($zipCode)
    {
        $zip = new CepLa($this->credential);
        $zip = $zip->getAddressFromZipcode($zipCode);

        return $zip;
    }
}
