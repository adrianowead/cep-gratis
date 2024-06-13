<?php

namespace Wead\ZipCode\Tests\WS;

use PHPUnit\Framework\TestCase;
use Wead\ZipCode\WS\ApiCEP;

class ApiCEPTest extends TestCase
{
    /**
     * @dataProvider getCepDefaultWithOutput
     */
    public function testGetAddressFromApiCEPDefaultUsage(string $zipCode, array $expected)
    {
        $cep = new ApiCEP();
        $out = $cep->getAddressFromZipcode($zipCode);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }

    /**
     * @dataProvider getCepEmptyDefaultWithOutput
     */
    public function testGetAddressEmptyFromApiCEPDefaultUsage(string $zipCode, array $expected)
    {
        $cep = new ApiCEP();
        $out = $cep->getAddressFromZipcode($zipCode);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }

    /**
     * @dataProvider getMockInputOutput
     */
    public function testNormalizeResponseApiCEPDefaultUsage(array $address, array $expected)
    {
        $cep = new ApiCEP();

        $reflect = new \ReflectionObject($cep);
        $method = $reflect->getMethod('normalizeResponse');
        $method->setAccessible(true); // turns private method accessible

        $out = $method->invoke($cep, $address);

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
                    "api" => "ApiCEP"
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
                    "api" => "ApiCEP"
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
