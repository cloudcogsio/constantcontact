<?php
namespace Cloudcogs\ConstantContact\Exception;

class CurlSetupException extends \Exception
{
    protected $message = "Unable to initialize cURL";
}