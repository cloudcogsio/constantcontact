<?php
namespace Cloudcogs\ConstantContact\Api\Contacts\Exception;

class InvalidContactSubResourceString extends \Exception
{

    public function __construct($message = null, $code = null, $previous = null)
    {
        $this->message = "Invalid contact include value [".$message."]. Valid values: [custom_fields, list_memberships, phone_numbers, street_addresses, taggings]";
        parent::__construct($message = null, $code = null, $previous = null);
    }
}

