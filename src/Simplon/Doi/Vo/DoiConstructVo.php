<?php

    namespace Simplon\Doi\Vo;

    use Simplon\Doi\Iface\DoiDatabaseInterface;
    use Simplon\Doi\Iface\DoiEmailInterface;

    class DoiConstructVo
    {
        protected $_databaseHandler;
        protected $_emailHandler;

        // ######################################

        /**
         * @return DoiDatabaseInterface
         */
        public function getDatabaseHandler()
        {
            return $this->_databaseHandler;
        }

        // ######################################

        /**
         * @param DoiDatabaseInterface $databaseHandler
         *
         * @return DoiConstructVo
         */
        public function setDatabaseHandler(DoiDatabaseInterface $databaseHandler)
        {
            $this->_databaseHandler = $databaseHandler;

            return $this;
        }

        // ######################################

        /**
         * @return DoiEmailInterface
         */
        public function getEmailHandler()
        {
            return $this->_emailHandler;
        }

        // ######################################

        /**
         * @param DoiEmailInterface $emailHandler
         *
         * @return DoiConstructVo
         */
        public function setEmailHandler(DoiEmailInterface $emailHandler)
        {
            $this->_emailHandler = $emailHandler;

            return $this;
        }
    } 