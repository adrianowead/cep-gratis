<?php

namespace Wead\ZipCode\Tests\WS;

use PHPUnit\Framework\TestCase;
use Wead\ZipCode\WS\WideNet;

class WideNetTest extends TestCase
{
    public function testGetAddressFromZipcodeWideNetDefaultUsage()
    {
        $zipCode = '03624-0-10';

        $expected = [
            "status" => true,
            "address" => "Rua Luís Asson",
            "district" => "Vila Buenos Aires",
            "city" => "São Paulo",
            "state" => "SP",
            "api" => "WideNet"
        ];

        $wideNet = new WideNet();
        $out = $wideNet->getAddressFromZipcode($zipCode);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }
    
    public function testNormalizeResponseWideNetDefaultUsage()
    {
        $expected = [
            "status" => true,
            "address" => "Rua Luís Asson",
            "district" => "Vila Buenos Aires",
            "city" => "São Paulo",
            "state" => "SP",
            "api" => "WideNet"
        ];
        
        $address = [
            "address" => "Rua Luís Asson",
            "district" => "Vila Buenos Aires",
            "city" => "São Paulo",
            "state" => "SP",
        ];

        $wideNet = new WideNet();
        
        $reflect = new \ReflectionObject($wideNet);
        $method = $reflect->getMethod('normalizeResponse');
        $method->setAccessible(true); // turns private method accessible
        
        $out = $method->invoke($wideNet, $address);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }
}
