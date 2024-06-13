<?php

namespace Wead\ZipCode\Tests;

use Wead\ZipCode\Search;
use PHPUnit\Framework\TestCase;
use Wead\ZipCode\Exceptions\ZipCodeNotFoundException;

class SearchTest extends TestCase
{
    private $webManiaCredential = [
            'apiKey' => 't2BOfr8LUWPlhiaXOZMFCVYgkvwa0zmK',
            'apiSecret' => '6j4mw7OYBXaoHI7QEUzC6qWAoKJUjoV8UduvwhjwhvYB71dL'
    ];

    public function testSetMaxAttempts()
    {
        $tentativas = 5;

        $search = new Search();
        $out = $search->setMaxAttempts($tentativas);

        // must be qual structure and values
        self::assertEquals($tentativas, $out);
    }

    public function testSetCredential()
    {
        $search = new Search();
        $out = $search->setCredential('webMania', $this->webManiaCredential);

        // must be null (void)
        self::assertNull($out);
    }

    /**
     * @dataProvider getCepDefault
     */
    public function testGetAddressFromZipcodeDefaultUsage(string $zipCode)
    {
        $expected = [
            "status" => true,
            "address" => "Rua Luís Asson",
            "district" => "Vila Buenos Aires",
            "city" => "São Paulo",
            "state" => "SP"
        ];

        $search = new Search();
        $search->setMaxAttempts(10);
        $out = $search->getAddressFromZipcode($zipCode);

        if (isset($out['api'])) {
            unset($out['api']);
        }

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }

    /**
     * @dataProvider getCepDefault
     */
    public function testAttemptSearchDefaultUsage(string $zipCode)
    {
        $expected = [
            "status" => true,
            "address" => "Rua Luís Asson",
            "district" => "Vila Buenos Aires",
            "city" => "São Paulo",
            "state" => "SP"
        ];

        // reflect class to access private methods
        $search = new Search();

        $reflector = new \ReflectionObject($search);
        $method = $reflector->getMethod('attemptSearch');
        $method->setAccessible(true); // set accessible private method

        $out = $method->invoke($search, $zipCode);

        if (isset($out['api'])) {
            unset($out['api']);
        }

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }

    /**
     * @dataProvider getCepDefaultWithOutput
     */
    public function testGetAddressFromViaCepDirect(string $zipCode, array $expected)
    {
        $expected["api"] = "ViaCep";

        // reflect class to access private methods
        $search = new Search();

        $reflector = new \ReflectionObject($search);
        $method = $reflector->getMethod('getFromViaCep');
        $method->setAccessible(true); // set accessible private method

        $out = $method->invoke($search, $zipCode);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }

    /**
     * @dataProvider getCepDefaultWithOutputWebania
     */
    public function testGetAddressFromWebManiaDirect(string $zipCode, array $expected)
    {
        $expected["api"] = "WebMania";

        // reflect class to access private methods
        $search = new Search();
        $search->setCredential('webMania', $this->webManiaCredential);

        $reflector = new \ReflectionObject($search);
        $method = $reflector->getMethod('getFromWebMania');
        $method->setAccessible(true); // set accessible private method

        $out = $method->invoke($search, $zipCode, true);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }

    /**
     * @dataProvider getCepInvalid
     */
    public function testCustonExceptionInvalidZipcodeDefaultUsage(string $zipCode)
    {
        $this->expectException(ZipCodeNotFoundException::class);
        $this->expectExceptionMessage("Error to get address by zipcode: {$zipCode}");
        $this->expectExceptionCode(99);

        // reflect class to access private methods
        $search = new Search();

        $reflector = new \ReflectionObject($search);
        $method = $reflector->getMethod('attemptSearch');
        $method->setAccessible(true); // set accessible private method

        $out = $method->invoke($search, $zipCode);
    }

    /**
     * Returns all data to be used on tests
     */
    public function getCepInvalid()
    {
        return [
            "Cep Inválido" => ["00000000"]
        ];
    }

    /**
     * Returns all data to be used on tests
     */
    public function getCepDefault()
    {
        return [
            "Cep Luís Asson" => ["03-6240-10"]
        ];
    }

    /**
     * Returns all data to be used on tests
     */
    public function getCepDefaultWithOutput()
    {
        return [ // first level is each test
            "Dados esperados Luís Asson" => [ // second level is each param to test
                "036-24010",
                [
                    "status" => true,
                    "address" => "Rua Luís Asson",
                    "district" => "Vila Buenos Aires",
                    "city" => "São Paulo",
                    "state" => "SP"
                ]
            ]
        ];
    }

    /**
     * Returns all data to be used on tests
     */
    public function getCepDefaultWithOutputWebania()
    {
        return [ // first level is each test
            "Dados esperados Luís Asson" => [ // second level is each param to test
                "036-24010",
                [
                    "status" => false,
                    "address" => null,
                    "district" => null,
                    "city" => null,
                    "state" => null
                ]
            ]
        ];
    }
}
