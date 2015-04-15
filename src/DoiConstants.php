<?php

namespace Simplon\Doi;

/**
 * Doiconstants
 * @package Simplon\Doi
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class Doiconstants
{
    const STATUS_CREATED = 0;
    const STATUS_SENT = 1;
    const STATUS_SENT_ERR = 2;
    const STATUS_USED = 3;
    const STATUS_TIMEOUT = 4;

    const TOKEN_TIMEOUT_DEFAULT = 24;

    // --------------------------------------

    const ERR_DATABASE_COULD_NOT_SAVE_DATA_CODE = 1000;
    const ERR_DATABASE_COULD_NOT_SAVE_DATA_MESSAGE = 'Could not save data into database.';

    const ERR_DATABASE_COULD_NOT_FETCH_DATA_CODE = 1001;
    const ERR_DATABASE_COULD_NOT_FETCH_DATA_MESSAGE = 'Could not fetch data from database.';

    const ERR_EMAIL_COULD_NOT_SEND_CODE = 2000;
    const ERR_EMAIL_COULD_NOT_SEND_MESSAGE = 'Could not send email.';

    const ERR_VALIDATION_HAS_BEEN_USED_CODE = 3000;
    const ERR_VALIDATION_HAS_BEEN_USED_MESSAGE = 'This token has already been used.';

    const ERR_VALIDATION_HAS_MAXED_OUT_HOURS_CODE = 3001;
    const ERR_VALIDATION_HAS_MAXED_OUT_HOURS_MESSAGE = 'Token timed out. Age is older than {{hours}} hours.';
}