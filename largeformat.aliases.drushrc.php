<?php

$aliases['dev'] = array(
    'env' => 'dev',
    'root' => '/var/www/sites/thelargeformatblog.com/current/www',
    'remote-host' => 'naboo.welly.space',
    'remote-user' => 'www-data',
    'uri' => 'largeformatblog.dev.welly.space',
    'path-aliases' => array(
        '%files' => 'sites/default/files',
    ),
);

$aliases['prod'] = array(
    'env' => 'prod',
    'root' => '/var/www/sites/thelargeformatblog.com/current/www',
    'remote-host' => 'skywalker.welly.space',
    'remote-user' => 'www-data',
    'uri' => 'thelargeformatblog.com',
    'path-aliases' => array(
        '%files' => 'sites/default/files',
    ),
);
