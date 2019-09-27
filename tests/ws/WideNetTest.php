<?php

namespace Wead\ZipCode\Tests\WS;

use Wead\ZipCode\WS\WideNet;
use PHPUnit\Framework\TestCase;

class WideNetTest extends TestCase
{
    /**
     * @dataProvider getCepDefaultWithOutput
     */
    public function testGetAddressFromZipcodeWideNetDefaultUsage(string $zipCode, array $expected)
    {
        $wideNet = new WideNet();
        $out = $wideNet->getAddressFromZipcode($zipCode);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }
    
    /**
     * @dataProvider getMockInputOutput
     */
    public function testNormalizeResponseWideNetDefaultUsage(array $address, array $expected)
    {
        $wideNet = new WideNet();
        
        $reflect = new \ReflectionObject($wideNet);
        $method = $reflect->getMethod('normalizeResponse');
        $method->setAccessible(true); // turns private method accessible
        
        $out = $method->invoke($wideNet, $address);

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
                    "api" => "WideNet"
                ]
            ]
        ];
    }
    
    public function getMockInputOutput()
    {
        return [
            "Input e Output Luís Asson" => [
                [
                    "address" => "Rua Luís Asson",
                    "district" => "Vila Buenos Aires",
                    "city" => "São Paulo",
                    "state" => "SP",
                ],
                [
                    "status" => true,
                    "address" => "Rua Luís Asson",
                    "district" => "Vila Buenos Aires",
                    "city" => "São Paulo",
                    "state" => "SP",
                    "api" => "WideNet"
                ]
            ]
        ];
    }
}
