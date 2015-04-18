<?php

namespace Sample\Handler;

use Simplon\Doi\Iface\DoiDatabaseInterface;
use Simplon\Doi\Iface\DoiDataVoInterface;

/**
 * SampleDatabaseHandler
 * @package Sample\Handler
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class SampleDatabaseHandler implements DoiDatabaseInterface
{
    /**
     * @var string
     */
    private $databaseName = 'testing';

    /**
     * @var string
     */
    private $tableName = 'simplon_doi';

    /**
     * @return resource
     */
    private $dbh;

    /**
     * @param DoiDataVoInterface $doiDataVo
     *
     * @return bool
     */
    public function save(DoiDataVoInterface $doiDataVo)
    {
    }

    /**
     * @param $token
     *
     * @return bool|(DoiDataVo
     */
    public function fetch($token)
    {
    }

    /**
     * @param DoiDataVoInterface $doiDataVo
     *
     * @return bool
     */
    public function update(DoiDataVoInterface $doiDataVo)
    {
    }

    /**
     * @return resource
     */
    private function getDbh()
    {
        if ($this->dbh === null)
        {
            $this->dbh = mysql_connect('localhost', 'rootuser', 'rootuser');
            mysql_query('use ' . $this->databaseName, $this->dbh);
        }

        return $this->dbh;
    }
}