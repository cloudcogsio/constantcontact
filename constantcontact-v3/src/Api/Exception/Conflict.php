<?php
namespace Cloudcogs\ConstantContact\Api\Exception;

class Conflict extends \Exception
{
    protected $message = "Conflict. The resource you are creating or updating conflicts with an existing resource.";
    protected $code = 409;
}