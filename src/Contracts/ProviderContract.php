<?php

namespace Wead\ZipCode\Contracts;

abstract class ProviderContract
{
    public function getAddressFromZipcode($zipCode)
    {
    }

    private function normalizeResponse($address)
    {
    }
}
