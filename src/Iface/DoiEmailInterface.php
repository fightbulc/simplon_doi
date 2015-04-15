<?php

namespace Simplon\Doi\Iface;

/**
 * Interface DoiEmailInterface
 * @package Simplon\Doi\Iface
 * @author  Tino Ehrich (tino@bigpun.me)
 */
interface DoiEmailInterface
{
    /**
     * @param DoiDataVoInterface $doiDataVo
     *
     * @return bool
     */
    public function send(DoiDataVoInterface $doiDataVo);
}