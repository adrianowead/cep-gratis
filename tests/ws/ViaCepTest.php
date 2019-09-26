<?php

namespace Wead\ZipCode\Tests\WS;

use PHPUnit\Framework\TestCase;
use Wead\ZipCode\WS\ViaCep;

class ViaCepTest extends TestCase
{
    public function testGetAddressFromZipcodeViaCepDefaultUsage()
    {
        $zipCode = '03624-0-10';

        $expected = [
            "status" => true,
            "address" => "Rua Luís Asson",
            "district" => "Vila Buenos Aires",
            "city" => "São Paulo",
            "state" => "SP",
            "api" => "ViaCep"
        ];

        $viaCep = new ViaCep();
        $out = $viaCep->getAddressFromZipcode($zipCode);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }
    
    public function testNormalizeResponseViaCepDefaultUsage()
    {
        $expected = [
            "status" => true,
            "address" => "Rua Luís Asson",
            "district" => "Vila Buenos Aires",
            "city" => "São Paulo",
            "state" => "SP",
            "api" => "ViaCep"
        ];
        
        $address = [
            "logradouro" => "Rua Luís Asson",
            "bairro" => "Vila Buenos Aires",
            "localidade" => "São Paulo",
            "uf" => "SP",
        ];

        $viaCep = new ViaCep();
        
        $reflect = new \ReflectionObject($viaCep);
        $method = $reflect->getMethod('normalizeResponse');
        $method->setAccessible(true); // turns private method accessible
        
        $out = $method->invoke($viaCep, $address);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }
}
