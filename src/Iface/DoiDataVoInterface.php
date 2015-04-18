<?php

namespace Simplon\Doi\Iface;

use Simplon\Doi\DoiConstants;
use Simplon\Doi\Vo\DoiDataVo;

/**
 * Interface DoiDataVoInterface
 * @package Simplon\Doi\Iface
 * @author  Tino Ehrich (tino@bigpun.me)
 */
interface DoiDataVoInterface
{
    /**
     * @param string $token
     *
     * @return DoiDataVoInterface
     */
    public function setToken($token);

    /**
     * @return string
     */
    public function getToken();

    /**
     * @param string $connector
     *
     * @return DoiDataVoInterface
     */
    public function setConnector($connector);

    /**
     * @return string
     */
    public function getConnector();

    /**
     * @return array
     */
    public function getConnectorDataArray();

    /**
     * @param array $data
     *
     * @return DoiDataVo
     */
    public function setConnectorDataArray(array $data);

    /**
     * @param string $doiConnectorDataJson
     *
     * @return DoiDataVoInterface
     */
    public function setConnectorDataJson($doiConnectorDataJson);

    /**
     * @return string
     */
    public function getConnectorDataJson();

    /**
     * @param int $status
     *
     * @return DoiDataVoInterface
     */
    public function setStatus($status);

    /**
     * @return int
     */
    public function getStatus();

    /**
     * @return bool
     */
    public function hasValidStatus();

    /**
     * @return bool
     */
    public function hasBeenUsed();

    /**
     * @param int $createdAt
     *
     * @return DoiDataVoInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * @return int
     */
    public function getCreatedAt();

    /**
     * @param int $updatedAt
     *
     * @return DoiDataVoInterface
     */
    public function setUpdatedAt($updatedAt);

    /**
     * @return int
     */
    public function getUpdatedAt();

    /**
     * @param int $allowMaxHours
     *
     * @return int
     */
    public function getTimeOutLeft($allowMaxHours = DoiConstants::TOKEN_TIMEOUT_DEFAULT);

    /**
     * @param int $allowMaxHours
     *
     * @return bool
     */
    public function isTimedOut($allowMaxHours = DoiConstants::TOKEN_TIMEOUT_DEFAULT);

    /**
     * @return bool
     */
    public function isUsable();
}