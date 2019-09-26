<?php

namespace Wead\ZipCode\Tests\WS;

use PHPUnit\Framework\TestCase;
use Wead\ZipCode\WS\ViaCep;

class ViaCepTest extends TestCase
{
    /**
     * @dataProvider getCepDefaultWithOutput
     */
    public function testGetAddressFromZipcodeViaCepDefaultUsage(string $zipCode, array $expected)
    {
        $viaCep = new ViaCep();
        $out = $viaCep->getAddressFromZipcode($zipCode);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }
    
    /**
     * @dataProvider getMockInputOutput
     */
    public function testNormalizeResponseViaCepDefaultUsage(array $address, array $expected)
    {
        $viaCep = new ViaCep();
        
        $reflect = new \ReflectionObject($viaCep);
        $method = $reflect->getMethod('normalizeResponse');
        $method->setAccessible(true); // turns private method accessible
        
        $out = $method->invoke($viaCep, $address);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }
    
    /**
     * Returns all data to be used on tests
     */
    public function getCepDefaultWithOutput()
    {
        return [
            [
                "03624-0-10",
                [
                    "status" => true,
                    "address" => "Rua Luís Asson",
                    "district" => "Vila Buenos Aires",
                    "city" => "São Paulo",
                    "state" => "SP",
                    "api" => "ViaCep"
                ]
            ]
        ];
    }
    
    public function getMockInputOutput()
    {
        return [
            [
                [
                    "logradouro" => "Rua Luís Asson",
                    "bairro" => "Vila Buenos Aires",
                    "localidade" => "São Paulo",
                    "uf" => "SP",
                ],
                [
                    "status" => true,
                    "address" => "Rua Luís Asson",
                    "district" => "Vila Buenos Aires",
                    "city" => "São Paulo",
                    "state" => "SP",
                    "api" => "ViaCep"
                ]
            ]
        ];
    }
}
