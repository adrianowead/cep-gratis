<?php

namespace Wead\ZipCode\Tests\WS;

use PHPUnit\Framework\TestCase;
use Wead\ZipCode\WS\WebMania;

class WebManiaTest extends TestCase
{
    private $webManiaCredential = [
            'apiKey' => 't2BOfr8LUWPlhiaXOZMFCVYgkvwa0zmK',
            'apiSecret' => '6j4mw7OYBXaoHI7QEUzC6qWAoKJUjoV8UduvwhjwhvYB71dL'
    ];
    
    /**
     * @dataProvider getCepDefaultWithOutput
     */
    public function testGetAddressFromZipcodeWebManiaDefaultUsage(string $zipCode, array $expected)
    {
        $webMania = new WebMania($this->webManiaCredential);
        $out = $webMania->getAddressFromZipcode($zipCode);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }

    /**
     * @dataProvider getMockInputOutput
     */
    public function testNormalizeResponseWebManiaDefaultUsage(array $address, array $expected)
    {
        $webMania = new WebMania($this->webManiaCredential);
        
        $reflect = new \ReflectionObject($webMania);
        $method = $reflect->getMethod('normalizeResponse');
        $method->setAccessible(true); // turns private method accessible
        
        $out = $method->invoke($webMania, $address);

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
                    "api" => "WebMania"
                ]
            ]
        ];
    }
    
    public function getMockInputOutput()
    {
        return [
            [
                [
                    "endereco" => "Rua Luís Asson",
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
                    "api" => "WebMania"
                ]
            ]
        ];
    }
}
