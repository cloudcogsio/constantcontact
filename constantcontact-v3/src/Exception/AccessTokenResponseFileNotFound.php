<?php
namespace Cloudcogs\ConstantContact\Exception;

class AccessTokenResponseFileNotFound extends \Exception
{
    public function __construct($file)
    {
        $this->message = "AccessTokenResponseFile [".$file."] not found!";
        parent::__construct();
    }
}