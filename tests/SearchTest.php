<?php

namespace Wead\ZipCode\Tests;

use Wead\ZipCode\Search;
use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{
    private $webManiaCredential = [
            'apiKey' => 't2BOfr8LUWPlhiaXOZMFCVYgkvwa0zmK',
            'apiSecret' => '6j4mw7OYBXaoHI7QEUzC6qWAoKJUjoV8UduvwhjwhvYB71dL'
    ];
    
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
        $out = $search->getAddressFromZipcode($zipCode);

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
     * @dataProvider getCepDefaultWithOutput
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

        $out = $method->invoke($search, $zipCode);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }
    
    /**
     * @dataProvider getCepDefaultWithOutput
     */
    public function testGetAddressWideNetDirect(string $zipCode, array $expected)
    {
        $expected["api"] = "WideNet";

        // reflect class to access private methods
        $search = new Search();

        $reflector = new \ReflectionObject($search);
        $method = $reflector->getMethod('getFromWideNet');
        $method->setAccessible(true); // set accessible private method

        $out = $method->invoke($search, $zipCode);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }
    
    /**
     * @dataProvider getCepDefaultWithOutput
     */
    public function testGetAddressCepLaDirect(string $zipCode, array $expected)
    {
        $expected["api"] = "CepLa";

        // reflect class to access private methods
        $search = new Search();

        $reflector = new \ReflectionObject($search);
        $method = $reflector->getMethod('getFromCepLa');
        $method->setAccessible(true); // set accessible private method

        $out = $method->invoke($search, $zipCode);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }
    
    /**
     * Returns all data to be used on tests
     */
    public function getCepDefault()
    {
        return [
            ["03624-0-10"]
        ];
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
                    "state" => "SP"
                ]
            ]
        ];
    }
}
