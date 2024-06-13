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
[![Supported PHP version](https://img.shields.io/badge/PHP-%5E7.2.25_%7C%7C_%5E8.0-blue.svg)]()


## Dependências
[![Requires Guzzle](https://img.shields.io/badge/Guzzle->=7.8-lightgrey.svg)]()


# Serviços suportados

- [x] [ViaCep](https://viacep.com.br/)
- [x] [WebMania](https://webmaniabr.com/docs/rest-api-cep-ibge/)
- [x] [ApiCEP](https://apicep.com/)

# Serviços descontinuados (_não existem mais_)

- [CepLa](http://cep.la/)

## Instalação

É recomendada a utilização via composer:

    composer require wead/cep-gratis

## Uso

Exemplo de uso

```php
<?php

require "vendor/autoload.php";

use Wead\ZipCode\Search;

$search = new Search;
$search->setMaxAttempts(2); // optional, attempts to try get address (default 5)

var_dump($search->getAddressFromZipcode('03624010'));

```

[![BuyMeACoffee](https://img.shields.io/badge/Buy%20Me%20a%20Coffee-ffdd00?style=for-the-badge&logo=buy-me-a-coffee&logoColor=black)](https://www.paypal.com/donate/?hosted_button_id=WW7N7R4Z5RA6A)

![PayPal](https://raw.githubusercontent.com/adrianowead/adrianowead/main/img/qr-code-donate.png)