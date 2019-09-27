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

    public function setCredential($service, $credential = [])
    {
        if (is_string($service) && is_array($credential)) {
            $this->credential[$service] = $credential;
        }
    }

    public function getAddressFromZipcode($zipCode)
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
                
                if (!isset($found['address']) || !$found['status']) {
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
        $zip = new ViaCep(isset($this->credential['viaCep']) ? $this->credential['viaCep'] : []);
        $zip = $zip->getAddressFromZipcode($zipCode);

        return $zip;
    }

    private function getFromWebMania($zipCode)
    {
        $zip = new WebMania(isset($this->credential['webMania']) ? $this->credential['webMania'] : []);
        $zip = $zip->getAddressFromZipcode($zipCode);

        return $zip;
    }

    private function getFromWideNet($zipCode)
    {
        $zip = new WideNet(isset($this->credential['wideNet']) ? $this->credential['wideNet'] : []);
        $zip = $zip->getAddressFromZipcode($zipCode);

        return $zip;
    }

    private function getFromCepLa($zipCode)
    {
        $zip = new CepLa(isset($this->credential['cepLa']) ? $this->credential['cepLa'] : []);
        $zip = $zip->getAddressFromZipcode($zipCode);

        return $zip;
    }
}
