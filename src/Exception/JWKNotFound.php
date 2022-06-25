<?php
namespace Cloudcogs\ConstantContact\Exception;

class JWKNotFound extends \Exception
{
    protected $message = "Constant Contact JWK file not found.";
}