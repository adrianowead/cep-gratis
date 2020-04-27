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

use Wead\ZipCode\Exceptions\ZipCodeNotFoundException;
use Wead\ZipCode\WS\CepLa;
use Wead\ZipCode\WS\ViaCep;
use Wead\ZipCode\WS\WideNet;
use Wead\ZipCode\WS\WebMania;

class Search
{
    private $listApi = [
        'ViaCep',
        'WebMania',
        'WideNet',
        'CepLa'
    ];

    private $credential = [
        'webMania' => [
            'apiKey' => null,
            'apiSecret' => null
        ]
    ];

    private $maxAttempts = 5;
    private $countAttempts = 0;

    public function setMaxAttempts($maxAttempts = 5)
    {
        return $this->maxAttempts = (int) $maxAttempts;
    }

    public function setCredential($service, $credential = [])
    {
        if (is_string($service) && is_array($credential)) {
            $this->credential[$service] = $credential;
        }
    }

    public function getAddressFromZipcode($zipCode)
    {
        try {
            $found = $this->attemptSearch($zipCode);

            if (!$found['city']) {
                $this->countAttempts++;

                return $this->getAddressFromZipcode($zipCode);
            }

            $found['address'] = strlen(trim($found['address'])) == 0 ? "Não encontrado" : $found['address'];
            $found['district'] = strlen(trim($found['district'])) == 0 ? "Não encontrado" : $found['district'];

            return $found;
        } catch (\Exception $e) {
            if ($this->countAttempts < $this->maxAttempts) {
                $this->countAttempts++;

                return $this->getAddressFromZipcode($zipCode);
            }
        }
    }

    private function attemptSearch($zipCode)
    {
        $found = false;

        shuffle($this->listApi);

        foreach ($this->listApi as $api) {
            if (!$found) {
                switch ($api) {
                    case 'ViaCep':
                        $found = $this->getFromViaCep($zipCode);
                        break;

                    case 'WebMania':
                        $found = $this->getFromWebMania($zipCode);
                        break;

                    case 'WideNet':
                        $found = $this->getFromWideNet($zipCode);
                        break;

                    case 'CepLa':
                        $found = $this->getFromCepLa($zipCode);
                        break;
                }

                if (!isset($found['city']) || !$found['status'] || !$found['city'] || strlen(trim($found['city'])) == 0) {
                    $found = false;
                }
            }
        }

        if (!$found) {
            throw new ZipCodeNotFoundException("Error to get address by zipcode: {$zipCode}");
        }

        return $found;
    }

    private function getFromViaCep($zipCode)
    {
        $zip = new ViaCep();
        $zip = $zip->getAddressFromZipcode($zipCode);

        return $zip;
    }

    private function getFromWebMania($zipCode, $runningTest = false)
    {
        $zip = new WebMania(isset($this->credential['webMania']) ? $this->credential['webMania'] : []);
        $zip = $zip->getAddressFromZipcode($zipCode, $runningTest);

        return $zip;
    }

    private function getFromWideNet($zipCode)
    {
        $zip = new WideNet();
        $zip = $zip->getAddressFromZipcode($zipCode);

        return $zip;
    }

    private function getFromCepLa($zipCode)
    {
        $zip = new CepLa();
        $zip = $zip->getAddressFromZipcode($zipCode);

        return $zip;
    }
}
