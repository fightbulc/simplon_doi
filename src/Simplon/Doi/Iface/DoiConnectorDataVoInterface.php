<?php

    namespace Simplon\Doi\Iface;

    interface DoiConnectorDataVoInterface
    {
        /**
         * @param array $data
         *
         * @return $this
         */
        public function import(array $data);

        /**
         * @return array
         */
        public function export();

        /**
         * @return string
         */
        public function getEmail();
    } 