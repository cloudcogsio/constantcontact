<?php
namespace Cloudcogs\ConstantContact\Api\Exception;

class ForbiddenRequest extends \Exception
{
    protected $message = "Forbidden request. You lack the necessary scopes, you lack the necessary user privileges, or the application is deactivated.";
    protected $code = 403;
}