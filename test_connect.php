<?php
require 'vendor/autoload.php';

$redis = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => '127.0.0.1',
    'port'   => 6379,
]);

$redis->set('test', '¡Hola, Redis!');
echo "Valor almacenado en Redis: " . $redis->get('test') . PHP_EOL;
