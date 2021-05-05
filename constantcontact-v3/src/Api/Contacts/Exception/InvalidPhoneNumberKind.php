<?php
namespace Cloudcogs\ConstantContact\Api\Contacts\Exception;

class InvalidPhoneNumberKind extends \Exception
{

        public function __construct($message = null, $code = null, $previous = null)
        {
            parent::__construct("Invalid Phone Number Kind. [".$message."]", $code = null, $previous = null);
        }
}