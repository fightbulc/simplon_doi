<?php

namespace Simplon\Doi\Iface;

use Simplon\Doi\DoiConstants;

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
     * @param DoiConnectorDataVoInterface $doiConnectorDataVo
     *
     * @return DoiDataVoInterface
     */
    public function setConnectorDataVo(DoiConnectorDataVoInterface $doiConnectorDataVo);

    /**
     * @return DoiConnectorDataVoInterface
     */
    public function getConnectorDataVo();

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