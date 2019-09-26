<?php

namespace Wead\ZipCode\Tests\WS;

use PHPUnit\Framework\TestCase;
use Wead\ZipCode\WS\CepLa;

class CepLaTest extends TestCase
{
    public function testGetAddressFromZipcodeCepLaDefaultUsage()
    {
        $zipCode = '03624-0-10';

        $expected = [
            "status" => true,
            "address" => "Rua Luís Asson",
            "district" => "Vila Buenos Aires",
            "city" => "São Paulo",
            "state" => "SP",
            "api" => "CepLa"
        ];

        $cepLa = new CepLa();
        $out = $cepLa->getAddressFromZipcode($zipCode);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }
    
    public function testNormalizeResponseCepLaDefaultUsage()
    {
        $expected = [
            "status" => true,
            "address" => "Rua Luís Asson",
            "district" => "Vila Buenos Aires",
            "city" => "São Paulo",
            "state" => "SP",
            "api" => "CepLa"
        ];
        
        $address = [
            "logradouro" => "Rua Luís Asson",
            "bairro" => "Vila Buenos Aires",
            "cidade" => "São Paulo",
            "uf" => "SP",
        ];

        $cepLa = new CepLa();
        
        $reflect = new \ReflectionObject($cepLa);
        $method = $reflect->getMethod('normalizeResponse');
        $method->setAccessible(true); // turns private method accessible
        
        $out = $method->invoke($cepLa, $address);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }
}
