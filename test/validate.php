<?php

    require __DIR__ . '/init.php';

    $token = 'Pqb2UgtHG0MgIDgI';

    $doiDataVo = $doi->validate($token);
    
    /** @var \Sample\SampleConnectorDataVo $doiConnectorDataVo */
    $doiConnectorDataVo = $doiDataVo->getConnectorDataVo();
    
    var_dump([$doiDataVo, $doiDataVo->isTimedOut()]);