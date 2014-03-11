<?php

    namespace Simplon\Doi\Vo;

    use Simplon\Doi\Iface\DoiConnectorDataVoInterface;

    class DoiConnectorDataVo implements DoiConnectorDataVoInterface
    {
        protected $_email;

        // ######################################

        /**
         * @param array $data
         *
         * @return $this
         */
        public function import(array $data)
        {
            if (isset($data['email']))
            {
                $this->setEmail($data['email']);
            }
            
            return $this;
        }

        // ######################################

        /**
         * @return array
         */
        public function export()
        {
            return [
                'email' => $this->getEmail(),
            ];
        }

        // ######################################

        /**
         * @return string
         */
        public function getEmail()
        {
            return (string)$this->_email;
        }

        // ######################################

        /**
         * @param mixed $email
         *
         * @return $this
         */
        public function setEmail($email)
        {
            $this->_email = $email;

            return $this;
        }
    } 