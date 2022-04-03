<?php

require "vendor/autoload.php";

use Wead\ZipCode\Search;

$search = new Search;
$search->setMaxAttempts(2); // optional, attempts to try get address (default 5)

var_dump($search->getAddressFromZipcode('03624010'));