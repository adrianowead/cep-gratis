<?php

namespace Wead\ZipCode;

use Wead\ZipCode\WS\CepLa;
use Wead\ZipCode\WS\ViaCep;
use Wead\ZipCode\WS\WideNet;
use Wead\ZipCode\WS\WebMania;

class Search{
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

    public function setCredential($service, $credential = []){
        if( is_string($service) && is_array($credential) ){
            $this->credential[$service] = $credential;
        }
    }

    public function getAddressFromZipcode($zipCode){
        $found = false;
        $errors = [];

        // shuffle to not exceed api limits
        shuffle($this->listApiTest);

        foreach( $this->listApiTest as $k => $f ){
            if( !$found ){
                try{
                    $found = call_user_func([__CLASS__, $f], $zipCode);
                } catch(\Exception $e) {
                    $errors[$f] = $e->getMessage();

                    if( sizeof($errors) >= sizeof($this->listApiTest) ){
                        $msg = "";

                        foreach($errors as $i => $m){
                            $msg .= "[{$i}]: {$m}" . chr(13).chr(10) . chr(13).chr(10);
                        }

                        throw new \Exception("Error to get address by zipcode: " . chr(13).chr(10) . $msg);
                    }
                }
            }
        }

        return $found;
    }

    private function getFromViaCep($zipCode){
        $zip = new ViaCep($this->credential);
        $zip = $zip->getAddressFromZipcode($zipCode);

        return $zip;
    }

    private function getFromWebMania($zipCode){
        $zip = new WebMania($this->credential);
        $zip = $zip->getAddressFromZipcode($zipCode);

        return $zip;
    }

    private function getFromWideNet($zipCode){
        $zip = new WideNet($this->credential);
        $zip = $zip->getAddressFromZipcode($zipCode);

        return $zip;
    }

    private function getFromCepLa($zipCode){
        $zip = new CepLa($this->credential);
        $zip = $zip->getAddressFromZipcode($zipCode);

        return $zip;
    }
}