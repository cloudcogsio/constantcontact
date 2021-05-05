<?php
namespace Cloudcogs\ConstantContact\Api\ContactLists\Exception;

class InvalidList extends \Exception
{

        public function __construct($message = null, $code = null, $previous = null)
        {
            parent::__construct("Invalid List. Unable to access list [ID: ".$message."] ", $code = null, $previous = null);
        }
}