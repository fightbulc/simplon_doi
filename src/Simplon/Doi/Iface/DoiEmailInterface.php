<?php

    namespace Simplon\Doi\Iface;

    interface DoiEmailInterface
    {
        /**
         * @param DoiDataVoInterface $doiDataVo
         *
         * @return bool
         */
        public function send(DoiDataVoInterface $doiDataVo);
    } 