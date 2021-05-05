<?php
namespace Cloudcogs\ConstantContact\Api\Contacts\Exception;

class InvalidSendPermission extends \Exception
{

        public function __construct($message = null, $code = null, $previous = null)
        {
            parent::__construct("Invalid Send Permission. [".$message."]", $code = null, $previous = null);
        }
}