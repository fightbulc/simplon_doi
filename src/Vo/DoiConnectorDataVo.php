<?php

namespace Simplon\Doi\Vo;

use Simplon\Doi\Iface\DoiConnectorDataVoInterface;

/**
 * DoiConnectorDataVo
 * @package Simplon\Doi\Vo
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class DoiConnectorDataVo implements DoiConnectorDataVoInterface
{
    /**
     * @var string
     */
    private $email;

    /**
     * @param array $data
     *
     * @return DoiConnectorDataVo
     */
    public function import(array $data)
    {
        if (isset($data['email']))
        {
            $this->setEmail($data['email']);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function export()
    {
        return [
            'email' => $this->getEmail(),
        ];
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return (string)$this->email;
    }

    /**
     * @param string $email
     *
     * @return DoiConnectorDataVo
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}