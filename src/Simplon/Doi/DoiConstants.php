<?php

    namespace Simplon\Doi;

    class DoiConstants
    {
        CONST STATUS_CREATED = 0;
        CONST STATUS_SENT = 1;
        CONST STATUS_SENT_ERR = 2;
        CONST STATUS_USED = 3;

        // --------------------------------------

        CONST ERR_DATABASE_COULD_NOT_SAVE_DATA_CODE = 1000;
        CONST ERR_DATABASE_COULD_NOT_SAVE_DATA_MESSAGE = 'Could not save data into database.';

        CONST ERR_DATABASE_COULD_NOT_FETCH_DATA_CODE = 1001;
        CONST ERR_DATABASE_COULD_NOT_FETCH_DATA_MESSAGE = 'Could not fetch data from database.';

        CONST ERR_EMAIL_COULD_NOT_SEND_CODE = 2000;
        CONST ERR_EMAIL_COULD_NOT_SEND_MESSAGE = 'Could not send email.';

        CONST ERR_VALIDATION_HAS_BEEN_USED_CODE = 3000;
        CONST ERR_VALIDATION_HAS_BEEN_USED_MESSAGE = 'This token has already been used.';
    } 