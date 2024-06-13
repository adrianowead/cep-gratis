<?php

namespace Wead\ZipCode\Tests\Exceptions;

use PHPUnit\Framework\TestCase;
use Wead\ZipCode\Exceptions\ZipCodeNotFoundException;

class ZipCodeNotFoundExceptionText extends TestCase
{
    public function testToString()
    {
        $exception = new ZipCodeNotFoundException("Test", 123);

        $expected = "Wead\ZipCode\Exceptions\ZipCodeNotFoundException: [123]: Test\n";

        $this->assertEquals($expected, $exception->__toString());
    }
}
