<?php
namespace Cloudcogs\ConstantContact\Api\Exception;

class ResourceNotFound extends \Exception
{
    protected $message = "The requested resource was not found.";
    protected $code = 404;
}