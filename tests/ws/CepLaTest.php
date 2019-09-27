<?php

namespace Wead\ZipCode\Tests\WS;

use PHPUnit\Framework\TestCase;
use Wead\ZipCode\WS\CepLa;

class CepLaTest extends TestCase
{
    /**
     * @dataProvider getCepDefaultWithOutput
     */
    public function testGetAddressFromZipcodeCepLaDefaultUsage(string $zipCode, array $expected)
    {
        $cepLa = new CepLa();
        $out = $cepLa->getAddressFromZipcode($zipCode);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }
    
    /**
     * @dataProvider getMockInputOutput
     */
    public function testNormalizeResponseCepLaDefaultUsage(array $address, array $expected)
    {
        $cepLa = new CepLa();
        
        $reflect = new \ReflectionObject($cepLa);
        $method = $reflect->getMethod('normalizeResponse');
        $method->setAccessible(true); // turns private method accessible
        
        $out = $method->invoke($cepLa, $address);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }
    
    /**
     * Returns all data to be used on tests
     */
    public function getCepDefaultWithOutput()
    {
        return [
            "Dados esperados Luís Asson" => [
                "03624010",
                [
                    "status" => true,
                    "address" => "Rua Luís Asson",
                    "district" => "Vila Buenos Aires",
                    "city" => "São Paulo",
                    "state" => "SP",
                    "api" => "CepLa"
                ]
            ]
        ];
    }
    
    public function getMockInputOutput()
    {
        return [
            "Input e Output Luís Asson" => [
                [
                    "logradouro" => "Rua Luís Asson",
                    "bairro" => "Vila Buenos Aires",
                    "cidade" => "São Paulo",
                    "uf" => "SP",
                ],
                [
                    "status" => true,
                    "address" => "Rua Luís Asson",
                    "district" => "Vila Buenos Aires",
                    "city" => "São Paulo",
                    "state" => "SP",
                    "api" => "CepLa"
                ]
            ]
        ];
    }
}
