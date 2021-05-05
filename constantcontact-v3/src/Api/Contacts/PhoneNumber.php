<?php
namespace Cloudcogs\ConstantContact\Api\Contacts;

use Cloudcogs\ConstantContact\Api\AbstractSchema;
use Cloudcogs\ConstantContact\Api\Contacts\Exception\InvalidPhoneNumberKind;

class PhoneNumber extends AbstractSchema
{
    const KIND_HOME = 'home';
    const KIND_WORK = 'work';
    const KIND_MOBILE = 'mobile';
    const KIND_OTHER = 'other';

    /**
     * Unique ID for the phone number
     *
     * @return string
     */
    public function getPhoneNumberId() : string
    {
        return $this->phone_number_id;
    }

    /**
     * The contact's phone number, 1 of 2 allowed per contact, no more than 25 characters
     * Max Length: 25
     *
     * @return string
     */
    public function getPhoneNumber() : string
    {
        return $this->phone_number;
    }

    /**
     *
     * @param string $phone_number
     * @return \Cloudcogs\ConstantContact\Api\Contacts\PhoneNumber
     */
    public function setPhoneNumber(string $phone_number) : \Cloudcogs\ConstantContact\Api\Contacts\PhoneNumber
    {
        $this->phone_number = substr($phone_number, 0, 25);
        return $this;
    }

    /**
     * Describes the type of phone number; valid values are home, work, mobile, or other.
     * Enum: [home, work, mobile, other]
     *
     * @return string
     */
    public function getKind() : string
    {
        return $this->kind;
    }

    /**
     *
     * @param string $kind
     * @throws InvalidPhoneNumberKind
     * @return \Cloudcogs\ConstantContact\Api\Contacts\PhoneNumber
     */
    public function setKind(string $kind) : \Cloudcogs\ConstantContact\Api\Contacts\PhoneNumber
    {
        switch ($kind)
        {
            case self::KIND_HOME:
            case self::KIND_MOBILE:
            case self::KIND_OTHER:
            case self::KIND_WORK:
                $this->kind = $kind;
                return $this;
            default:
                throw new InvalidPhoneNumberKind($kind);
        }
    }

    /**
     * Date and time that the street address was created, in ISO-8601 format.
     * System generated.
     *
     * @return string
     */
    public function getCreatedAt() : string
    {
        return $this->created_at;
    }

    /**
     * Date and time that the phone_number was last updated, in ISO-8601 format.
     * System generated.
     *
     * @return string
     */
    public function getUpdatedAt() : string
    {
        return $this->updated_at;
    }

    /**
     * Identifies who last updated the phone_number; valid values are Contact or Account
     * Enum: [Account, Contact]
     *
     * @return string
     */
    public function getUpdateSource() : string
    {
        return $this->update_source;
    }

    /**
     * Describes who added the phone_number; valid values are Contact or Account.
     * Enum: [Account, Contact]
     *
     * @return string
     */
    public function getCreateSource() : string
    {
        return $this->create_source;
    }
}