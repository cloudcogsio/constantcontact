<?php
namespace Cloudcogs\ConstantContact\Api\ContactLists\Exception;

class InvalidActivityDeleteListResponse extends \Exception
{

        public function __construct($message = null, $code = null, $previous = null)
        {
            parent::__construct("Unable to access response data.", $code = null, $previous = null);
        }
}