<?php
namespace Cloudcogs\ConstantContact\Api\Contacts\Exception;

class InvalidContactsStatus extends \Exception
{

    public function __construct($message = null, $code = null, $previous = null)
    {
        $this->message = "Invalid contacts status [".$message."]. Valid values: [all, active, deleted, not_set, pending_confirmation, temp_hold, unsubscribed]";
        parent::__construct($message = null, $code = null, $previous = null);
    }
}

