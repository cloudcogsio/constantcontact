<?php
namespace Cloudcogs\ConstantContact\Api;

abstract class AbstractSchema extends \ArrayObject
{
    public function __construct(array $data = [])
    {
        parent::__construct($data, \ArrayObject::ARRAY_AS_PROPS);
    }

    public function __toString()
    {
        return json_encode($this->getArrayCopy());
    }
}