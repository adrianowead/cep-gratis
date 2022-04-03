# CEP Grátis

Consulta online à diversos serviços gratuitos de CEP online.

[![Release](https://img.shields.io/packagist/v/wead/cep-gratis)]()
[![Building](https://img.shields.io/circleci/build/github/adrianowead/cep-gratis?token=master)]()
[![Size](https://img.shields.io/github/repo-size/adrianowead/cep-gratis)]()
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/adrianowead/cep-gratis/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/adrianowead/cep-gratis/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/adrianowead/cep-gratis/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/adrianowead/cep-gratis/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/adrianowead/cep-gratis/badges/build.png?b=master)](https://scrutinizer-ci.com/g/adrianowead/cep-gratis/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/adrianowead/cep-gratis/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

## Necessário
[![Supported PHP version](https://img.shields.io/badge/PHP->%3D%205.6-blue.svg)]()


## Dependências
[![Requires Guzzle](https://img.shields.io/badge/Guzzle-~6.0-lightgrey.svg)]()


# Serviços suportados

- [x] [ViaCep](https://viacep.com.br/)
- [x] [CepLa](http://cep.la/)
- [x] [WebMania](https://webmaniabr.com/docs/rest-api-cep-ibge/)
- [x] [ApiCEP](https://apicep.com/)

## Instalação

É recomendada a utilização via composer:

    composer require wead/cep-gratis

## Uso

Exemplo de uso

```php
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

```
