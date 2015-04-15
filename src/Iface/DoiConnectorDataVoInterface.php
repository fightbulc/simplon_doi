<?php

namespace Simplon\Doi\Iface;

/**
 * Interface DoiConnectorDataVoInterface
 * @package Simplon\Doi\Iface
 * @author  Tino Ehrich (tino@bigpun.me)
 */
interface DoiConnectorDataVoInterface
{
    /**
     * @param array $data
     *
     * @return DoiConnectorDataVoInterface
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