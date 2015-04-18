<?php

require __DIR__ . '/init.php';

$connector = 'nl01';

$data = [
    'email'     => 'tom@hamburg.de',
    'firstName' => 'Tom',
    'lastName'  => 'Berger',
];

// save to database
$doiDataVo = $doi->create($connector, $data);
var_dump([$doiDataVo, $doiDataVo->getDataJson()]);