<?php
namespace Cloudcogs\ConstantContact\Api\Exception;

class InvalidAccessToken extends \Exception
{
    protected $message = "The Access Token used is invalid.";
    protected $code = 401;
}