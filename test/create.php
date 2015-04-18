<?php

require __DIR__ . '/init.php';

// create data
$createVo = (new \Simplon\Doi\Vo\DoiCreateVo())
    ->setConnector('NEWSLETTER')
    ->setConnectorDataArray([
        'email'     => 'tom@hamburg.de',
        'firstName' => 'Tom',
        'lastName'  => 'Berger',
    ]);

// save to database
$doiDataVo = $doi->create($createVo);
var_dump([$doiDataVo, $doiDataVo->getConnectorDataJson()]);