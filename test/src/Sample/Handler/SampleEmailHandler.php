<?php

    namespace Sample\Handler;

    use Simplon\Doi\Iface\DoiDataVoInterface;
    use Simplon\Doi\Iface\DoiEmailInterface;

    class SampleEmailHandler implements DoiEmailInterface
    {
        /**
         * @param DoiDataVoInterface $doiDataVo
         *
         * @return bool
         */
        public function send(DoiDataVoInterface $doiDataVo)
        {
            return TRUE;
        }
    } 