<?php

require __DIR__ . '/init.php';

$token = 'Pqb2UgtHG0MgIDgI';

$doiDataVo = $doi->fetch($token);
$doiData = $doiDataVo->getDataArray();
var_dump([$doiDataVo, $doiDataVo->getTimeOutLeft()]);