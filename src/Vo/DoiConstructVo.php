<?php

namespace Simplon\Doi\Vo;

use Simplon\Doi\Iface\DoiDatabaseInterface;
use Simplon\Doi\Iface\DoiEmailInterface;

/**
 * DoiConstructVo
 * @package Simplon\Doi\Vo
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class DoiConstructVo
{
    /**
     * @var DoiDatabaseInterface
     */
    private $databaseHandler;

    /**
     * @var DoiEmailInterface
     */
    private $emailHandler;

    /**
     * @return DoiDatabaseInterface
     */
    public function getDatabaseHandler()
    {
        return $this->databaseHandler;
    }

    /**
     * @param DoiDatabaseInterface $databaseHandler
     *
     * @return DoiConstructVo
     */
    public function setDatabaseHandler(DoiDatabaseInterface $databaseHandler)
    {
        $this->databaseHandler = $databaseHandler;

        return $this;
    }

    /**
     * @return DoiEmailInterface
     */
    public function getEmailHandler()
    {
        return $this->emailHandler;
    }

    /**
     * @param DoiEmailInterface $emailHandler
     *
     * @return DoiConstructVo
     */
    public function setEmailHandler(DoiEmailInterface $emailHandler)
    {
        $this->emailHandler = $emailHandler;

        return $this;
    }
} 