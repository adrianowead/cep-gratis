<?php

return [
    'target_php_version' => '7.2',
    'directory_list' => [
        'src',
        'vendor/symfony/console',
        'vendor/guzzlehttp/guzzle',
        'vendor/psr/http-message'
    ],

    'exclude_analysis_directory_list' => [
        'vendor/'
    ],
];