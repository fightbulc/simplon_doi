<?php

namespace Sample\Handler;

use Sample\SampleConnectorDataVo;
use Simplon\Doi\Iface\DoiDatabaseInterface;
use Simplon\Doi\Iface\DoiDataVoInterface;
use Simplon\Doi\Vo\DoiDataVo;
use Simplon\Mysql\Mysql;
use Simplon\Mysql\MysqlConfigVo;

class SampleDatabaseHandler implements DoiDatabaseInterface
{
    protected $_dbh;

    // ######################################

    /**
     * @return Mysql
     */
    protected function _getDbh()
    {
        if (!$this->_dbh)
        {
            $config = [
                'server'   => 'localhost',
                'database' => 'test',
                'username' => 'root',
                'password' => 'root',
            ];

            $this->_dbh = new Mysql(new MysqlConfigVo($config));
        }

        return $this->_dbh;
    }

    // ######################################

    /**
     * @param DoiDataVoInterface $doiDataVo
     *
     * @return bool
     */
    public function save(DoiDataVoInterface $doiDataVo)
    {
        $tableName = 'simplon_doi';

        $connectorData = $doiDataVo
            ->getConnectorDataVo()
            ->export();

        $data = [
            'token'               => $doiDataVo->getToken(),
            'connector'           => $doiDataVo->getConnector(),
            'connector_data_json' => json_encode($connectorData),
            'status'              => $doiDataVo->getStatus(),
            'created_at'          => $doiDataVo->getCreatedAt(),
            'updated_at'          => $doiDataVo->getUpdatedAt(),
        ];

        $response = $this->_getDbh()
            ->insert($tableName, $data);

        if ($response !== false)
        {
            return true;
        }

        return false;
    }

    // ######################################

    /**
     * @param $token
     *
     * @return bool|(DoiDataVo
     */
    public function fetch($token)
    {
        $response = $this->_getDbh()
            ->fetchRow('SELECT * from simplon_doi WHERE token = :token', ['token' => $token]);

        if ($response !== false)
        {
            $doiConnectorDataVo = (new SampleConnectorDataVo())
                ->import(json_decode($response['connector_data_json'], true));

            return (new DoiDataVo())
                ->setToken($response['token'])
                ->setConnector($response['connector'])
                ->setConnectorDataVo($doiConnectorDataVo)
                ->setStatus($response['status'])
                ->setCreatedAt($response['created_at'])
                ->setUpdatedAt($response['updated_at']);
        }

        return false;
    }

    // ######################################

    /**
     * @param DoiDataVoInterface $doiDataVo
     *
     * @return bool
     */
    public function update(DoiDataVoInterface $doiDataVo)
    {
        $tableName = 'simplon_doi';

        $conds = [
            'token' => $doiDataVo->getToken(),
        ];

        $connectorData = $doiDataVo
            ->getConnectorDataVo()
            ->export();

        $data = [
            'token'               => $doiDataVo->getToken(),
            'connector'           => $doiDataVo->getConnector(),
            'connector_data_json' => json_encode($connectorData),
            'status'              => $doiDataVo->getStatus(),
            'created_at'          => $doiDataVo->getCreatedAt(),
            'updated_at'          => $doiDataVo->getUpdatedAt(),
        ];

        $response = $this->_getDbh()
            ->update($tableName, $conds, $data);

        if ($response !== false)
        {
            return true;
        }

        return false;
    }
}