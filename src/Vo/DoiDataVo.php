<?php

namespace Simplon\Doi\Vo;

use Simplon\Doi\DoiConstants;
use Simplon\Doi\Iface\DoiConnectorDataVoInterface;
use Simplon\Doi\Iface\DoiDataVoInterface;

class DoiDataVo implements DoiDataVoInterface
{
    protected $_token;
    protected $_connector;
    protected $_connectorDataVo;
    protected $_status;
    protected $_createdAt;
    protected $_updatedAt;

    /**
     * @return string
     */
    public function getToken()
    {
        return (string)$this->_token;
    }

    /**
     * @param mixed $token
     *
     * @return $this
     */
    public function setToken($token)
    {
        $this->_token = $token;

        return $this;
    }

    /**
     * @return string
     */
    public function getConnector()
    {
        return (string)$this->_connector;
    }

    /**
     * @param mixed $connector
     *
     * @return $this
     */
    public function setConnector($connector)
    {
        $this->_connector = $connector;

        return $this;
    }

    /**
     * @param DoiConnectorDataVoInterface $sampleConnectorDataVo
     *
     * @return $this
     */
    public function setConnectorDataVo(DoiConnectorDataVoInterface $sampleConnectorDataVo)
    {
        $this->_connectorDataVo = $sampleConnectorDataVo;

        return $this;
    }

    /**
     * @return DoiConnectorDataVoInterface
     */
    public function getConnectorDataVo()
    {
        return $this->_connectorDataVo;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return (int)$this->_status;
    }

    /**
     * @return bool
     */
    public function hasValidStatus()
    {
        return in_array($this->getStatus(), [DoiConstants::STATUS_CREATED, DoiConstants::STATUS_SENT]);
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
    public function hasBeenSent()
    {
        return $this->getStatus() === DoiConstants::STATUS_SENT;
    }

    /**
     * @return bool
     */
    public function hasSentError()
    {
        return $this->getStatus() === DoiConstants::STATUS_SENT_ERR;
    }

    /**
     * @param mixed $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->_status = $status;

        return $this;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return (int)$this->_createdAt;
    }

    /**
     * @param mixed $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->_createdAt = $createdAt;

        return $this;
    }

    /**
     * @return int
     */
    public function getUpdatedAt()
    {
        return (int)$this->_updatedAt;
    }

    /**
     * @param mixed $updateAt
     *
     * @return $this
     */
    public function setUpdatedAt($updateAt)
    {
        $this->_updatedAt = $updateAt;

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
     * @return bool
     */
    public function isUsable()
    {
        return $this->hasValidStatus() && $this->isTimedOut() === false;
    }
} 