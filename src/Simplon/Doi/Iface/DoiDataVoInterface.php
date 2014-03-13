<?php

    namespace Simplon\Doi\Iface;

    use Simplon\Doi\DoiConstants;

    interface DoiDataVoInterface
    {
        /**
         * @param string $token
         *
         * @return $this
         */
        public function setToken($token);

        /**
         * @return string
         */
        public function getToken();

        /**
         * @param string $connector
         *
         * @return $this
         */
        public function setConnector($connector);

        /**
         * @return string
         */
        public function getConnector();

        /**
         * @param DoiConnectorDataVoInterface $doiConnectorDataVo
         *
         * @return $this
         */
        public function setConnectorDataVo(DoiConnectorDataVoInterface $doiConnectorDataVo);

        /**
         * @return DoiConnectorDataVoInterface
         */
        public function getConnectorDataVo();

        /**
         * @param int $status
         *
         * @return $this
         */
        public function setStatus($status);

        /**
         * @return int
         */
        public function getStatus();

        /**
         * @return bool
         */
        public function hasBeenUsed();

        /**
         * @param int $createdAt
         *
         * @return $this
         */
        public function setCreatedAt($createdAt);

        /**
         * @return int
         */
        public function getCreatedAt();

        /**
         * @param int $updatedAt
         *
         * @return $this
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
    } 