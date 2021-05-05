<?php
namespace Cloudcogs\ConstantContact\Api\Exception;

class InternalError extends \Exception
{
    protected $message = "There was a problem with our internal service.";
    protected $code = 500;
}