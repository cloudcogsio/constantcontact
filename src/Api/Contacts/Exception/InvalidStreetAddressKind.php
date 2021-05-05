<?php
namespace Cloudcogs\ConstantContact\Api\Contacts\Exception;

class InvalidStreetAddressKind extends \Exception
{

        public function __construct($message = null, $code = null, $previous = null)
        {
            parent::__construct("Invalid Street Address Kind. [".$message."]", $code = null, $previous = null);
        }
}