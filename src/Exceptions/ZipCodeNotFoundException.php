<?php

namespace Wead\ZipCode\Exceptions;

class ZipCodeNotFoundException extends \Exception
{
    public function __construct($message, $code = 99, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
