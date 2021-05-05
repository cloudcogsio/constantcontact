<?php
namespace Cloudcogs\ConstantContact\Api\Contacts\Exception;

class InvalidUpdateSource extends \Exception
{

        public function __construct($message = null, $code = null, $previous = null)
        {
            parent::__construct("Invalid Update Source. [".$message."]", $code = null, $previous = null);
        }
}