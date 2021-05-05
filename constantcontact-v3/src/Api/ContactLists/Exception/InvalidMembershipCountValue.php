<?php
namespace Cloudcogs\ConstantContact\Api\ContactLists\Exception;

class InvalidMembershipCountValue extends \Exception
{

    public function __construct($message = null, $code = null, $previous = null)
    {
        $this->message = "Invalid include_membership_count value [".$message."]. Valid enums: [all,active]";
        parent::__construct();
    }
}

