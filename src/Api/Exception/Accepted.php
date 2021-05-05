<?php
namespace Cloudcogs\ConstantContact\Api\Exception;

class Accepted extends \Exception
{
    protected $message = "Accepted";
    protected $code = 202;
}