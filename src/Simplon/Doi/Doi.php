<?php

    namespace Simplon\Doi;

    use Simplon\Doi\Iface\DoiDatabaseInterface;
    use Simplon\Doi\Iface\DoiDataVoInterface;
    use Simplon\Doi\Iface\DoiEmailInterface;
    use Simplon\Doi\Vo\DoiCreateVo;
    use Simplon\Doi\Vo\DoiDataVo;

    class Doi
    {
        protected $_doiDatabaseHandler;
        protected $_doiEmailHandler;

        // ######################################

        /**
         * @param DoiDatabaseInterface $doiDatabaseInterface
         * @param DoiEmailInterface $doiEmailInterface
         */
        public function __construct(DoiDatabaseInterface $doiDatabaseInterface, DoiEmailInterface $doiEmailInterface)
        {
            $this->_doiDatabaseHandler = $doiDatabaseInterface;
            $this->_doiEmailHandler = $doiEmailInterface;
        }

        // ######################################

        /**
         * @return Iface\DoiDatabaseInterface
         */
        protected function _getDoiDatabaseHandler()
        {
            return $this->_doiDatabaseHandler;
        }

        // ######################################

        /**
         * @return Iface\DoiEmailInterface
         */
        protected function _getDoiEmailHandler()
        {
            return $this->_doiEmailHandler;
        }

        // ######################################

        /**
         * @param $length
         * @param $characters
         *
         * @return string
         */
        protected function _createToken($length, $characters)
        {
            $randomString = '';

            // generate token
            for ($i = 0; $i < $length; $i++)
            {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }

            return $randomString;
        }

        // ######################################

        /**
         * @param DoiDataVoInterface $doiDataVo
         *
         * @return bool
         * @throws DoiException
         */
        protected function _update(DoiDataVoInterface $doiDataVo)
        {
            $response = $this
                ->_getDoiDatabaseHandler()
                ->update($doiDataVo);

            if ($response === FALSE)
            {
                throw new DoiException(
                    DoiConstants::ERR_DATABASE_COULD_NOT_SAVE_DATA_CODE,
                    DoiConstants::ERR_DATABASE_COULD_NOT_SAVE_DATA_MESSAGE
                );
            }

            return TRUE;
        }

        // ######################################

        /**
         * @param DoiDataVoInterface $doiDataVo
         *
         * @return bool
         * @throws DoiException
         */
        protected function _sendEmail(DoiDataVoInterface $doiDataVo)
        {
            $response = $this
                ->_getDoiEmailHandler()
                ->send($doiDataVo);

            if ($response === FALSE)
            {
                $doiDataVo
                    ->setStatus(DoiConstants::STATUS_SENT_ERR)
                    ->setUpdatedAt(time());

                $this->_update($doiDataVo);

                throw new DoiException(
                    DoiConstants::ERR_EMAIL_COULD_NOT_SEND_CODE,
                    DoiConstants::ERR_EMAIL_COULD_NOT_SEND_MESSAGE
                );
            }

            // ----------------------------------

            $doiDataVo
                ->setStatus(DoiConstants::STATUS_SENT)
                ->setUpdatedAt(time());

            $this->_update($doiDataVo);

            // ----------------------------------

            return TRUE;
        }

        // ######################################

        /**
         * @param DoiCreateVo $doiCreateVo
         *
         * @return DoiDataVoInterface
         * @throws DoiException
         */
        public function create(DoiCreateVo $doiCreateVo)
        {
            // create token

            $token = $this->_createToken(
                $doiCreateVo->getTokenLenght(),
                $doiCreateVo->getTokenCharacters()
            );

            // ----------------------------------

            // create data

            /** @var DoiDataVoInterface $doiDataVo */
            $doiDataVo = (new DoiDataVo())
                ->setToken($token)
                ->setConnector($doiCreateVo->getConnector())
                ->setConnectorDataVo($doiCreateVo->getConnectorDataVo())
                ->setStatus(DoiConstants::STATUS_CREATED)
                ->setCreatedAt(time())
                ->setUpdatedAt(time());

            // ----------------------------------

            // save in database

            $response = $this
                ->_getDoiDatabaseHandler()
                ->save($doiDataVo);

            if ($response === FALSE)
            {
                throw new DoiException(
                    DoiConstants::ERR_DATABASE_COULD_NOT_SAVE_DATA_CODE,
                    DoiConstants::ERR_DATABASE_COULD_NOT_SAVE_DATA_MESSAGE
                );
            }

            // ----------------------------------

            // send email

            $this->_sendEmail($doiDataVo);

            // ----------------------------------

            return $doiDataVo;
        }

        // ######################################

        /**
         * @param string $token
         *
         * @return bool|DoiDataVoInterface
         * @throws DoiException
         */
        public function fetch($token)
        {
            $doiDataVo = $this
                ->_getDoiDatabaseHandler()
                ->fetch($token);

            if ($doiDataVo === FALSE)
            {
                throw new DoiException(
                    DoiConstants::ERR_DATABASE_COULD_NOT_FETCH_DATA_CODE,
                    DoiConstants::ERR_DATABASE_COULD_NOT_FETCH_DATA_MESSAGE
                );
            }

            return $doiDataVo;
        }

        // ######################################

        /**
         * @param string $token
         * @param int $allowMaxHours
         *
         * @return bool|DoiDataVoInterface
         * @throws DoiException
         */
        public function validate($token, $allowMaxHours = 24)
        {
            // fetch data

            $doiDataVo = $this->fetch($token);

            if ($doiDataVo->hasBeenUsed() === TRUE)
            {
                throw new DoiException(
                    DoiConstants::ERR_VALIDATION_HAS_BEEN_USED_CODE,
                    DoiConstants::ERR_VALIDATION_HAS_BEEN_USED_MESSAGE
                );
            }

            // ----------------------------------

            // test for timeout

            if ($doiDataVo->isTimedOut($allowMaxHours) === TRUE)
            {
                $doiDataVo
                    ->setStatus(DoiConstants::STATUS_TIMEOUT)
                    ->setUpdatedAt(time());

                $this->_update($doiDataVo);

                throw new DoiException(
                    DoiConstants::ERR_VALIDATION_HAS_MAXED_OUT_HOURS_CODE,
                    str_replace('{{hours}}', $allowMaxHours, DoiConstants::ERR_VALIDATION_HAS_MAXED_OUT_HOURS_MESSAGE)
                );
            }

            // ----------------------------------

            // looks cool - save as used

            $doiDataVo
                ->setStatus(DoiConstants::STATUS_USED)
                ->setUpdatedAt(time());

            $this->_update($doiDataVo);

            // ----------------------------------

            return $doiDataVo;
        }

        // ######################################

        /**
         * @param string $token
         *
         * @return bool|DoiDataVoInterface
         * @throws DoiException
         */
        public function resend($token)
        {
            // fetch data

            $doiDataVo = $this->fetch($token);

            // ----------------------------------

            // send email

            $this->_sendEmail($doiDataVo);

            // ----------------------------------

            return $doiDataVo;
        }
    }