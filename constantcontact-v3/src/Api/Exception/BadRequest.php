<?php
namespace Cloudcogs\ConstantContact\Api\Exception;

class BadRequest extends \Exception
{
    protected $message = "Bad request. Either the JSON was malformed or there was a data validation error.";
    protected $code = 400;
}