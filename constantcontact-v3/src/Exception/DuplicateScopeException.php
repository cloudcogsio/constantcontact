<?php
namespace Cloudcogs\ConstantContact\Exception;

class DuplicateScopeException extends \Exception
{
    public function __construct($scope)
    {
        $this->message = "Scope [".$scope."] already added!";
        parent::__construct();
    }
}