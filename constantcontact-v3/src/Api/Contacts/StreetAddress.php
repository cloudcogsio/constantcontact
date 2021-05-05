<?php
namespace Cloudcogs\ConstantContact\Api\Contacts;

use Cloudcogs\ConstantContact\Api\AbstractSchema;
use Cloudcogs\ConstantContact\Api\Contacts\Exception\InvalidStreetAddressKind;

class StreetAddress extends AbstractSchema
{
    const KIND_HOME = 'home';
    const KIND_WORK = 'work';
    const KIND_OTHER = 'other';

    /**
     * Unique ID for the street address
     *
     * @return string
     */
    public function getStreetAddressId() : string
    {
        return $this->street_address_id;
    }

    /**
     * (required) Describes the type of address; valid values are home, work, or other.
     * Enum: [home, work, other]
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
     * @throws InvalidStreetAddressKind
     * @return \Cloudcogs\ConstantContact\Api\Contacts\StreetAddress
     */
    public function setKind(string $kind) : \Cloudcogs\ConstantContact\Api\Contacts\StreetAddress
    {
        switch ($kind)
        {
            case self::KIND_HOME:
            case self::KIND_OTHER:
            case self::KIND_WORK:
                $this->kind = $kind;
                return $this;
            default:
                throw new InvalidStreetAddressKind($kind);
        }
    }

    /**
     * Number and street of the address.
     * Max Length: 255
     *
     * @return string
     */
    public function getStreet() : string
    {
        return $this->street;
    }

    /**
     *
     * @param string $street
     * @return \Cloudcogs\ConstantContact\Api\Contacts\StreetAddress
     */
    public function setStreet(string $street) : \Cloudcogs\ConstantContact\Api\Contacts\StreetAddress
    {
        $this->street = substr($street, 0, 255);
        return $this;
    }

    /**
     * The name of the city where the contact lives.
     * Max Length: 50
     *
     * @return string
     */
    public function getCity() : string
    {
        return $this->city;
    }

    /**
     *
     * @param string $city
     * @return \Cloudcogs\ConstantContact\Api\Contacts\StreetAddress
     */
    public function setCity(string $city) : \Cloudcogs\ConstantContact\Api\Contacts\StreetAddress
    {
        $this->city = substr($city, 0, 50);
        return $this;
    }

    /**
     * The name of the state or province where the contact lives.
     * Max Length: 50
     *
     * @return string
     */
    public function getState() : string
    {
        return $this->state;
    }

    /**
     *
     * @param string $state
     * @return \Cloudcogs\ConstantContact\Api\Contacts\StreetAddress
     */
    public function setState(string $state) : \Cloudcogs\ConstantContact\Api\Contacts\StreetAddress
    {
        $this->state = substr($state, 0, 50);
        return $this;
    }

    /**
     * The zip or postal code of the contact.
     * Max Length: 50
     *
     * @return string
     */
    public function getPostalCode() : string
    {
        return $this->postal_code;
    }

    /**
     *
     * @param string $postal_code
     * @return \Cloudcogs\ConstantContact\Api\Contacts\StreetAddress
     */
    public function setPostalCode(string $postal_code) : \Cloudcogs\ConstantContact\Api\Contacts\StreetAddress
    {
        $this->postal_code= substr($postal_code, 0, 50);
        return $this;
    }

    /**
     * The name of the country where the contact lives.
     * Max Length: 50
     *
     * @return string
     */
    public function getCountry() : string
    {
        return $this->country;
    }

    /**
     *
     * @param string $country
     * @return \Cloudcogs\ConstantContact\Api\Contacts\StreetAddress
     */
    public function setCountry(string $country) : \Cloudcogs\ConstantContact\Api\Contacts\StreetAddress
    {
        $this->country= substr($country, 0, 50);
        return $this;
    }

    /**
     * Date and time that the street address was created, in ISO-8601 format.
     * System generated.
     * read only
     *
     * @return string
     */
    public function getCreatedAt() : string
    {
        return $this->created_at;
    }

    /**
     * Date and time that the street address was last updated, in ISO-8601 format.
     * System generated.
     * read only
     *
     * @return string
     */
    public function getUpdatedAt() : string
    {
        return $this->updated_at;
    }
}