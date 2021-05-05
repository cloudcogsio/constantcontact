<?php
namespace Cloudcogs\ConstantContact\Api\Contacts\Exception;

class InvalidContact extends \Exception
{

        public function __construct($message = null, $code = null, $previous = null)
        {
            parent::__construct("Invalid Contact. Unable to access contact [ID: ".$message."] ", $code = null, $previous = null);
        }
}