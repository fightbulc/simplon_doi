<?php

    namespace Sample;

    use Simplon\Doi\Vo\DoiConnectorDataVo;

    class SampleConnectorDataVo extends DoiConnectorDataVo
    {
        protected $_firstname;
        protected $_lastname;

        // ######################################

        /**
         * @param array $data
         *
         * @return $this
         */
        public function import(array $data)
        {
            parent::import($data);

            if (isset($data['firstname']))
            {
                $this->setFirstname($data['firstname']);
            }

            if (isset($data['lastname']))
            {
                $this->setLastname($data['lastname']);
            }

            return $this;
        }

        // ######################################

        /**
         * @return array
         */
        public function export()
        {
            $customExport = [
                'firstname' => $this->getFirstname(),
                'lastname'  => $this->getLastname(),
            ];

            return array_merge($customExport, parent::export());
        }

        // ######################################

        /**
         * @return string
         */
        public function getFirstname()
        {
            return (string)$this->_firstname;
        }

        // ######################################

        /**
         * @param mixed $firstname
         *
         * @return SampleConnectorDataVo
         */
        public function setFirstname($firstname)
        {
            $this->_firstname = $firstname;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getLastname()
        {
            return (string)$this->_lastname;
        }

        // ######################################

        /**
         * @param mixed $lastname
         *
         * @return SampleConnectorDataVo
         */
        public function setLastname($lastname)
        {
            $this->_lastname = $lastname;

            return $this;
        }
    } 