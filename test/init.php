<?php

    require __DIR__ . '/vendor/autoload.php';

    // ##########################################

    $doi = new \Simplon\Doi\Doi(
        new \Sample\Handler\SampleDatabaseHandler(),
        new \Sample\Handler\SampleEmailHandler()
    );