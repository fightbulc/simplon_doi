<?php

namespace Simplon\Doi\Vo;

use Simplon\Doi\Iface\DoiConnectorDataVoInterface;

/**
 * DoiCreateVo
 * @package Simplon\Doi\Vo
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class DoiCreateVo
{
    /**
     * @var string
     */
    private $connector;

    /**
     * @var DoiConnectorDataVo
     */
    private $connectorDataVo;

    /**
     * @var int
     */
    private $tokenLenght = 16;

    /**
     * @var string
     */
    private $tokenCharacters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

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
     * @return DoiCreateVo
     */
    public function setConnector($connector)
    {
        $this->connector = $connector;

        return $this;
    }

    /**
     * @param DoiConnectorDataVoInterface $sampleConnectorDataVo
     *
     * @return DoiCreateVo
     */
    public function setConnectorDataVo(DoiConnectorDataVoInterface $sampleConnectorDataVo)
    {
        $this->connectorDataVo = $sampleConnectorDataVo;

        return $this;
    }

    /**
     * @return DoiConnectorDataVoInterface
     */
    public function getConnectorDataVo()
    {
        return $this->connectorDataVo;
    }

    /**
     * @return string
     */
    public function getTokenCharacters()
    {
        return (string)$this->tokenCharacters;
    }

    /**
     * @param string $tokenCharacters
     *
     * @return DoiCreateVo
     */
    public function setTokenCharacters($tokenCharacters)
    {
        $this->tokenCharacters = $tokenCharacters;

        return $this;
    }

    /**
     * @return int
     */
    public function getTokenLenght()
    {
        return (int)$this->tokenLenght;
    }

    /**
     * @param int $tokenLenght
     *
     * @return DoiCreateVo
     */
    public function setTokenLenght($tokenLenght)
    {
        $this->tokenLenght = $tokenLenght;

        return $this;
    }
} 