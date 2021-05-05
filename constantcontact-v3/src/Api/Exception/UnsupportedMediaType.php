<?php
namespace Cloudcogs\ConstantContact\Api\Exception;

class UnsupportedMediaType extends \Exception
{
    protected $message = "Unsupported Media Type.";
    protected $code = 415;
}
