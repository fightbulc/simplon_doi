<?php

namespace Simplon\Doi;

use Simplon\Doi\Iface\DoiDatabaseInterface;
use Simplon\Doi\Iface\DoiDataVoInterface;
use Simplon\Doi\Iface\DoiEmailInterface;
use Simplon\Doi\Vo\DoiCreateVo;
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
     * @var DoiEmailInterface
     */
    private $doiEmailHandler;

    /**
     * @param DoiDatabaseInterface $doiDatabaseInterface
     * @param DoiEmailInterface    $doiEmailInterface
     */
    public function __construct(DoiDatabaseInterface $doiDatabaseInterface, DoiEmailInterface $doiEmailInterface)
    {
        $this->doiDatabaseHandler = $doiDatabaseInterface;
        $this->doiEmailHandler = $doiEmailInterface;
    }

    /**
     * @param DoiCreateVo $doiCreateVo
     *
     * @return DoiDataVoInterface
     * @throws DoiException
     */
    public function create(DoiCreateVo $doiCreateVo)
    {
        // create token

        $token = $this->createToken(
            $doiCreateVo->getTokenLenght(),
            $doiCreateVo->getTokenCharacters()
        );

        // ----------------------------------

        // create data

        /** @var DoiDataVoInterface $doiDataVo */
        $doiDataVo = (new DoiDataVo())
            ->setToken($token)
            ->setConnector($doiCreateVo->getConnector())
            ->setConnectorDataVo($doiCreateVo->getConnectorDataVo())
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

        // send email

        $this->sendEmail($doiDataVo);

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
     * @param string $token
     *
     * @return bool|DoiDataVoInterface
     * @throws DoiException
     */
    public function resend($token)
    {
        // fetch data

        $doiDataVo = $this->fetch($token);

        // ----------------------------------

        // send email

        $this->sendEmail($doiDataVo);

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
     * @return DoiEmailInterface
     */
    private function getDoiEmailHandler()
    {
        return $this->doiEmailHandler;
    }

    /**
     * @param $length
     * @param $characters
     *
     * @return string
     */
    private function createToken($length, $characters)
    {
        $randomString = '';

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

    /**
     * @param DoiDataVoInterface $doiDataVo
     *
     * @return bool
     * @throws DoiException
     */
    private function sendEmail(DoiDataVoInterface $doiDataVo)
    {
        $response = $this
            ->getDoiEmailHandler()
            ->send($doiDataVo);

        if ($response === false)
        {
            $doiDataVo
                ->setStatus(DoiConstants::STATUS_SENT_ERR)
                ->setUpdatedAt(time());

            $this->update($doiDataVo);

            throw new DoiException(
                DoiConstants::ERR_EMAIL_COULD_NOT_SEND_CODE,
                DoiConstants::ERR_EMAIL_COULD_NOT_SEND_MESSAGE
            );
        }

        // ----------------------------------

        $doiDataVo
            ->setStatus(DoiConstants::STATUS_SENT)
            ->setUpdatedAt(time());

        $this->update($doiDataVo);

        // ----------------------------------

        return true;
    }
}