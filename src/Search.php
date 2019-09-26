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
    private $countAttempts = [
        'ViaCep' => 0,
        'WebMania' => 0,
        'WideNet' => 0,
        'CepLa' => 0,
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
        $errors = [];
        
        // on first exec shuffe
        // preserve keys
        uksort($this->countAttempts, function ($ka, $kb) {
            return rand() > rand() ? 1 : 0;
        });

        while (!$found) {
            // lower attempts
            asort($this->countAttempts);

            $api = array_keys($this->countAttempts)[0];
            
            $this->countAttempts[$api]++;
            
            if ($this->countAttempts[$api] > 3) {
                throw new ZipCodeNotFoundException("Error to get address by zipcode: {$zipCode}");
            }
            
            try {
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

                    default:
                        $found = false;
                        break;
                }
                
                $found = is_array($found) ? $found['status'] === true ? $found : false : false;
            } catch (\Exception $e) {
                $errors[$api] = $e->getMessage();

                if (sizeof($errors) >= sizeof($this->countAttempts)) {
                    $msg = "";

                    foreach ($errors as $i => $m) {
                        $msg .= "[{$i}]: {$m}" . PHP_EOL . PHP_EOL;
                    }

                    throw new ZipCodeNotFoundException(
                        "Error to get address by zipcode: {$zipCode}"
                    );
                }
            }
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
