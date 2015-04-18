<?php

namespace Simplon\Doi\Vo;

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
     * @var array
     */
    private $connectorDataArray;

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
     * @param array $data
     *
     * @return DoiCreateVo
     */
    public function setConnectorDataArray(array $data)
    {
        $this->connectorDataArray = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getConnectorDataArray()
    {
        return $this->connectorDataArray;
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