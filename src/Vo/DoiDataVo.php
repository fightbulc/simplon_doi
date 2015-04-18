<?php

namespace Simplon\Doi\Vo;

use Simplon\Doi\DoiConstants;
use Simplon\Doi\Iface\DoiDataVoInterface;

/**
 * DoiDataVo
 * @package Simplon\Doi\Vo
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class DoiDataVo implements DoiDataVoInterface
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $connector;

    /**
     * @var string
     */
    private $connectorDataJson;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $updatedAt;

    /**
     * @return string
     */
    public function getToken()
    {
        return (string)$this->token;
    }

    /**
     * @param string $token
     *
     * @return DoiDataVo
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return string
     */
    public function getConnector()
    {
        return (string)$this->connector;
    }

    /**
     * @param string $connector
     *
     * @return DoiDataVo
     */
    public function setConnector($connector)
    {
        $this->connector = $connector;

        return $this;
    }

    /**
     * @param array $data
     *
     * @return DoiDataVo
     */
    public function setConnectorDataArray(array $data)
    {
        $this->connectorDataJson = json_encode($data);

        return $this;
    }

    /**
     * @return array
     */
    public function getConnectorDataArray()
    {
        return (array)json_decode($this->connectorDataJson, true);
    }

    /**
     * @param string $connectorDataJson
     *
     * @return DoiDataVo
     */
    public function setConnectorDataJson($connectorDataJson)
    {
        $this->connectorDataJson = $connectorDataJson;

        return $this;
    }

    /**
     * @return string
     */
    public function getConnectorDataJson()
    {
        return (string)$this->connectorDataJson;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return (int)$this->status;
    }

    /**
     * @return bool
     */
    public function hasValidStatus()
    {
        return $this->getStatus() === DoiConstants::STATUS_CREATED;
    }

    /**
     * @return bool
     */
    public function hasBeenUsed()
    {
        return $this->getStatus() === DoiConstants::STATUS_USED;
    }

    /**
     * @return bool
     */
    public function hasSentError()
    {
        return $this->getStatus() === DoiConstants::STATUS_SENT_ERR;
    }

    /**
     * @param string $status
     *
     * @return DoiDataVo
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return (int)$this->createdAt;
    }

    /**
     * @param int $createdAt
     *
     * @return DoiDataVo
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return int
     */
    public function getUpdatedAt()
    {
        return (int)$this->updatedAt;
    }

    /**
     * @param int $updateAt
     *
     * @return DoiDataVo
     */
    public function setUpdatedAt($updateAt)
    {
        $this->updatedAt = $updateAt;

        return $this;
    }

    /**
     * @param int $allowMaxHours
     *
     * @return int
     */
    public function getTimeOutLeft($allowMaxHours = DoiConstants::TOKEN_TIMEOUT_DEFAULT)
    {
        $timeLimitSeconds = $this->getCreatedAt() + ($allowMaxHours * 60 * 60);
        $timeOutLeft = $timeLimitSeconds - time();

        return $timeOutLeft <= 0 ? 0 : $timeOutLeft;
    }

    /**
     * @param int $allowMaxHours
     *
     * @return bool
     */
    public function isTimedOut($allowMaxHours = DoiConstants::TOKEN_TIMEOUT_DEFAULT)
    {
        if ($this->getTimeOutLeft($allowMaxHours) === 0)
        {
            return true;
        }

        return false;
    }

    /**
     * @param int $allowMaxHours
     *
     * @return bool
     */
    public function isUsable($allowMaxHours = DoiConstants::TOKEN_TIMEOUT_DEFAULT)
    {
        return $this->hasValidStatus() && $this->isTimedOut($allowMaxHours) === false;
    }
} 