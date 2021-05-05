<?php
namespace Cloudcogs\ConstantContact\Api\Exception;

class TemporarilyUnavailable extends \Exception
{
    protected $message = "Our internal service is temporarily unavailable.";
    protected $code = 503;
}