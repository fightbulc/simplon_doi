<?php

namespace Simplon\Doi;

use Simplon\Doi\Iface\DoiDatabaseInterface;
use Simplon\Doi\Iface\DoiDataVoInterface;
use Simplon\Doi\Vo\DoiDataVo;

/**
 * Doi
 * @package Simplon\Doi
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class Doi
{
    /**
     * @var DoiDatabaseInterface
     */
    private $doiDatabaseHandler;

    /**
     * @param DoiDatabaseInterface $doiDatabaseInterface
     */
    public function __construct(DoiDatabaseInterface $doiDatabaseInterface)
    {
        $this->doiDatabaseHandler = $doiDatabaseInterface;
    }

    /**
     * @param string $connector
     * @param array  $data
     * @param int    $tokenLength
     *
     * @return DoiDataVoInterface
     * @throws DoiException
     */
    public function create($connector, array $data, $tokenLength = DoiConstants::TOKEN_LENGTH)
    {
        // create token

        $token = $this->createToken($tokenLength);

        // ----------------------------------

        // create data

        /** @var DoiDataVoInterface $doiDataVo */
        $doiDataVo = (new DoiDataVo())
            ->setToken($token)
            ->setConnector($connector)
            ->setDataArray($data)
            ->setStatus(DoiConstants::STATUS_CREATED)
            ->setCreatedAt(time())
            ->setUpdatedAt(time());

        // ----------------------------------

        // save in database

        $response = $this
            ->getDoiDatabaseHandler()
            ->save($doiDataVo);

        if ($response === false)
        {
            throw new DoiException(
                DoiConstants::ERR_DATABASE_COULD_NOT_SAVE_DATA_CODE,
                DoiConstants::ERR_DATABASE_COULD_NOT_SAVE_DATA_MESSAGE
            );
        }

        // ----------------------------------

        return $doiDataVo;
    }

    /**
     * @param string $token
     *
     * @return bool|DoiDataVoInterface
     * @throws DoiException
     */
    public function fetch($token)
    {
        $doiDataVo = $this
            ->getDoiDatabaseHandler()
            ->fetch($token);

        if ($doiDataVo === false)
        {
            throw new DoiException(
                DoiConstants::ERR_DATABASE_COULD_NOT_FETCH_DATA_CODE,
                DoiConstants::ERR_DATABASE_COULD_NOT_FETCH_DATA_MESSAGE
            );
        }

        return $doiDataVo;
    }

    /**
     * @param string $token
     * @param int    $allowMaxHours
     *
     * @return bool|DoiDataVoInterface
     * @throws DoiException
     */
    public function validate($token, $allowMaxHours = 24)
    {
        // fetch data

        $doiDataVo = $this->fetch($token);

        if ($doiDataVo->hasBeenUsed() === true)
        {
            throw new DoiException(
                DoiConstants::ERR_VALIDATION_HAS_BEEN_USED_CODE,
                DoiConstants::ERR_VALIDATION_HAS_BEEN_USED_MESSAGE
            );
        }

        // ----------------------------------

        // test for timeout

        if ($doiDataVo->isTimedOut($allowMaxHours) === true)
        {
            $doiDataVo
                ->setStatus(DoiConstants::STATUS_TIMEOUT)
                ->setUpdatedAt(time());

            $this->update($doiDataVo);

            throw new DoiException(
                DoiConstants::ERR_VALIDATION_HAS_MAXED_OUT_HOURS_CODE,
                str_replace('{{hours}}', $allowMaxHours, DoiConstants::ERR_VALIDATION_HAS_MAXED_OUT_HOURS_MESSAGE)
            );
        }

        // ----------------------------------

        // looks cool - save as used

        $doiDataVo
            ->setStatus(DoiConstants::STATUS_USED)
            ->setUpdatedAt(time());

        $this->update($doiDataVo);

        // ----------------------------------

        return $doiDataVo;
    }

    /**
     * @return DoiDatabaseInterface
     */
    private function getDoiDatabaseHandler()
    {
        return $this->doiDatabaseHandler;
    }

    /**
     * @param int $length
     *
     * @return string
     */
    private function createToken($length)
    {
        $randomString = '';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // generate token
        for ($i = 0; $i < $length; $i++)
        {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    /**
     * @param DoiDataVoInterface $doiDataVo
     *
     * @return bool
     * @throws DoiException
     */
    private function update(DoiDataVoInterface $doiDataVo)
    {
        $response = $this
            ->getDoiDatabaseHandler()
            ->update($doiDataVo);

        if ($response === false)
        {
            throw new DoiException(
                DoiConstants::ERR_DATABASE_COULD_NOT_SAVE_DATA_CODE,
                DoiConstants::ERR_DATABASE_COULD_NOT_SAVE_DATA_MESSAGE
            );
        }

        return true;
    }
}