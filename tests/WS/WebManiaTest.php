<?php

namespace Wead\ZipCode\Tests\WS;

use Wead\ZipCode\WS\WebMania;
use PHPUnit\Framework\TestCase;

class WebManiaTest extends TestCase
{
    private $webManiaCredential = [];

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
            "Dados esperados Luís Asson" => [
                "03624010",
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

    /**
     * Returns all data to be used on tests
     */
    public function getCepEmptyDefaultWithOutput()
    {
        return [
            "Dados esperados vazio" => [
                "00000000",
                [
                    "status" => false,
                    "address" => null,
                    "district" => null,
                    "city" => null,
                    "state" => null,
                    "api" => "WebMania"
                ]
            ]
        ];
    }

    public function getMockInputOutput()
    {
        return [
            "Input e Output Luís Asson" => [
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
