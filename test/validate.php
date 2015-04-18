<?php

require __DIR__ . '/init.php';

$token = 'Pqb2UgtHG0MgIDgI';
$doiDataVo = $doi->validate($token);
var_dump([$doiDataVo, $doiDataVo->isTimedOut()]);