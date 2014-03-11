<?php

    require __DIR__ . '/init.php';

    // set custom connector data
    $sampleConnectorDataVo = (new \Sample\SampleConnectorDataVo())
        ->setEmail('tom@hamburg.de')
        ->setFirstname('Tom')
        ->setLastname('Berger');

    // create data
    $createVo = (new \Simplon\Doi\Vo\DoiCreateVo())
        ->setConnector('EMVAL')
        ->setConnectorDataVo($sampleConnectorDataVo);

    // create entry
    $doiDataVo = $doi->create($createVo);

    var_dump([$doiDataVo, $doiDataVo->getConnectorDataVo()]);