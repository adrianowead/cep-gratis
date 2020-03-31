<?php

require "vendor/autoload.php";

use Wead\ZipCode\Search;

// web mania api (optional)
$webMania = [
    'apiKey' => 'NHRvLagxDUWw70Guhd4fMSKccftSjvtL',
    'apiSecret' => 'qVB3AmE2N5UKSL2ok01YP6gVUEqERYQLiPGtye65C6OQZAd0'
];

$search = new Search;
$search->setCredential('webMania', $webMania);
$search->setMaxAttempts(2); // optional, attempts to try get address (default 5)

var_dump($search->getAddressFromZipcode('03624010'));