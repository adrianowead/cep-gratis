<?php

/**
 * Esta página só funciona com os pacotes de produção
 * /usr/bin/php5.6 /usr/bin/composer install --no-dev
 * 
 * Os pacotes de desenv dependem de versões novas do PHP, incompatíveis com o 5.6
 */

use Wead\ZipCode\Search;

require "vendor/autoload.php";

if(isset($_GET['cep']) && strlen(trim($_GET['cep'])) > 0) {
    $cep = trim($_GET['cep']);

    $search = new Search;
    var_dump($search->getAddressFromZipcode($cep));
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste de busca de CEP</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <form method="GET" class="mt-5 mb-5">
                    <div class="form-group">
                        <label for="cep">CEP</label>
                        <input type="tel" name="cep" class="form-control" id="cep" aria-describedby="cepHelp"
                            placeholder="Informe o CEP">
                        <small id="cepHelp" class="form-text text-muted">O CEP será utilizado para testar a pesquisa com
                            a biblioteca.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#cep').mask('00000-000');
    });
    </script>
</body>

</html>