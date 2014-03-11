<?php

    namespace Simplon\Doi\Vo;

    use Simplon\Doi\Iface\DoiConnectorDataVoInterface;

    class DoiCreateVo
    {
        protected $_connector;
        protected $_connectorDataVo;
        protected $_tokenLenght = 16;
        protected $_tokenCharacters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // ######################################

        /**
         * @return string
         */
        public function getConnector()
        {
            return (string)$this->_connector;
        }

        // ######################################

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

        // ######################################

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

        // ######################################

        /**
         * @return DoiConnectorDataVoInterface
         */
        public function getConnectorDataVo()
        {
            return $this->_connectorDataVo;
        }

        // ######################################

        /**
         * @return string
         */
        public function getTokenCharacters()
        {
            return (string)$this->_tokenCharacters;
        }

        // ######################################

        /**
         * @param string $tokenCharacters
         *
         * @return DoiCreateVo
         */
        public function setTokenCharacters($tokenCharacters)
        {
            $this->_tokenCharacters = $tokenCharacters;

            return $this;
        }

        // ######################################

        /**
         * @return int
         */
        public function getTokenLenght()
        {
            return (int)$this->_tokenLenght;
        }

        // ######################################

        /**
         * @param int $tokenLenght
         *
         * @return DoiCreateVo
         */
        public function setTokenLenght($tokenLenght)
        {
            $this->_tokenLenght = $tokenLenght;

            return $this;
        }
    } 