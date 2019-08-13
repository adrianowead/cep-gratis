# CEP Grátis

Consulta online à diversos serviços gratuitos de CEP online.

## Necessário
[![Supported PHP version](https://img.shields.io/badge/PHP->%3D%205.6-blue.svg)]()


## Dependências
[![Requires Guzzle](https://img.shields.io/badge/Guzzle-~6.0-lightgrey.svg)]()


# Serviços suportados

- [x] [ViaCep](https://viacep.com.br/)
- [x] [CepLa](http://cep.la/)
- [x] [WebMania](https://webmaniabr.com/docs/rest-api-cep-ibge/)
- [x] [WideNet](https://apps.widenet.com.br/busca-cep/api-de-consulta)
- [ ] Correios

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

var_dump($search->getAddressFromZipcode('03624010'));

```