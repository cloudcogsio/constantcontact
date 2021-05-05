<?php
namespace Cloudcogs\ConstantContact\Api\Contacts;

use Cloudcogs\ConstantContact\Api\AbstractSchema;

class ContactCustomField extends AbstractSchema
{
    /**
     * The custom_field's unique ID
     * Max Length: 255
     * required
     *
     * @return string
     */
    public function getCustomFieldId() : string
    {
        return $this->custom_field_id;
    }

    /**
     *
     * @param string $custom_field_id
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactCustomField
     */
    public function setCustomFieldId(string $custom_field_id) : \Cloudcogs\ConstantContact\Api\Contacts\ContactCustomField
    {
        $this->custom_field_id = substr($custom_field_id, 0, 255);
        return $this;
    }

    /**
     * The custom_field value.
     * Max Length: 255
     * required
     *
     * @return string
     */
    public function getValue() : string
    {
        return $this->value;
    }

    /**
     *
     * @param string $value
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactCustomField
     */
    public function setValue(string $value) : \Cloudcogs\ConstantContact\Api\Contacts\ContactCustomField
    {
        $this->value = substr($value, 0, 255);
        return $this;
    }
}