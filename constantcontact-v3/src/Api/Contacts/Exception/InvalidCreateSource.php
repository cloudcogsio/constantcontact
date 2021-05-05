<?php
namespace Cloudcogs\ConstantContact\Api\Contacts\Exception;

class InvalidCreateSource extends \Exception
{

        public function __construct($message = null, $code = null, $previous = null)
        {
            parent::__construct("Invalid Create Source. [".$message."]", $code = null, $previous = null);
        }
}