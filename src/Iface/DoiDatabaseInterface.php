<?php

namespace Simplon\Doi\Iface;

/**
 * Interface DoiDatabaseInterface
 * @package Simplon\Doi\Iface
 * @author  Tino Ehrich (tino@bigpun.me)
 */
interface DoiDatabaseInterface
{
    /**
     * @param DoiDataVoInterface $doiDataVo
     *
     * @return bool
     */
    public function save(DoiDataVoInterface $doiDataVo);

    /**
     * @param $token
     *
     * @return bool|DoiDataVoInterface
     */
    public function fetch($token);

    /**
     * @param DoiDataVoInterface $doiDataVo
     *
     * @return bool
     */
    public function update(DoiDataVoInterface $doiDataVo);
}