#!/usr/bin/env php
<?php

if(is_file(__DIR__ . "/vendor/autoload.php")){
    require_once __DIR__ . "/vendor/autoload.php";
} else if(is_file(__DIR__ . "/../autoload.php")){
    require_once __DIR__ . "/../autoload.php";
}

use Wead\ZipCode\Search;

// web mania api (optional)
$webMania = [
    'apiKey' => 'NHRvLagxDUWw70Guhd4fMSKccftSjvtL',
    'apiSecret' => 'qVB3AmE2N5UKSL2ok01YP6gVUEqERYQLiPGtye65C6OQZAd0'
];

$search = new Search;
$search->setCredential('webMania', $webMania);

$zipCode = '03624010';

if( isset($argv) && sizeof($argv) > 1 ){
    $zipCode = isset($argv[1]) ? preg_replace('/[^0-9]/im', '', $argv[1]) : $zipCode;
}

print_r($search->getAddressFromZipcode($zipCode));