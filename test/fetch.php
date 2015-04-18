<?php

require __DIR__ . '/init.php';

$token = 'Pqb2UgtHG0MgIDgI';

$doiDataVo = $doi->fetch($token);
$doiConnectorDataArray = $doiDataVo->getConnectorDataArray();
var_dump([$doiDataVo, $doiDataVo->getTimeOutLeft()]);