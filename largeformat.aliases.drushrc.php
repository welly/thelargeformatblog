<?php

$aliases['local'] = array(
    'env' => 'dev',
    'root' => '/vagrant/app',
    'uri' => 'thelargeformatblog.dev',
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

$options['shell-aliases']['pull-files'] = '!drush rsync @largeformat.prod:%files/ @largeformat.local:%files';
