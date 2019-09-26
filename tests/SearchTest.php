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
    
    public function testGetAddressFromZipcodeDefaultUsage()
    {
        $zipCode = '03624-0-10';

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
    
    public function testGetAddressFromViaCepDirect()
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

        // reflect class to access private methods
        $search = new Search();

        $reflector = new \ReflectionObject($search);
        $method = $reflector->getMethod('getFromViaCep');
        $method->setAccessible(true); // set accessible private method

        $out = $method->invoke($search, $zipCode);

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }
    
    public function testGetAddressFromWebManiaDirect()
    {
        $zipCode = '03624-0-10';

        $expected = [
            "status" => true,
            "address" => "Rua Luís Asson",
            "district" => "Vila Buenos Aires",
            "city" => "São Paulo",
            "state" => "SP",
            "api" => "WebMania"
        ];

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
    
    public function testGetAddressWideNetDirect()
    {
        $zipCode = '03624-0-10';

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
        $method = $reflector->getMethod('getFromWideNet');
        $method->setAccessible(true); // set accessible private method

        $out = $method->invoke($search, $zipCode);
        
        if (isset($out['api'])) {
            unset($out['api']);
        }

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }
    
    public function testGetAddressCepLaDirect()
    {
        $zipCode = '03624-0-10';

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
        $method = $reflector->getMethod('getFromCepLa');
        $method->setAccessible(true); // set accessible private method

        $out = $method->invoke($search, $zipCode);
        
        if (isset($out['api'])) {
            unset($out['api']);
        }

        // must be qual structure and values
        self::assertEquals($expected, $out);
    }
}
