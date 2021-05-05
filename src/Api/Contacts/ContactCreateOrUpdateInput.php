<?php
namespace Cloudcogs\ConstantContact\Api\Contacts;

use Cloudcogs\ConstantContact\Api\AbstractSchema;

class ContactCreateOrUpdateInput extends AbstractSchema
{
    public function __construct(array $data = null)
    {
        parent::__construct(($data == null)?[]:$data);
    }

    /**
     * The email address for the contact.
     *
     * @return string
     */
    public function getEmailAddress() : string
    {
        return $this->email_address;
    }

    /**
     * The email address for the contact.
     * This method identifies each unique contact using their email address.
     * If the email address exists in the account, this method updates the contact.
     * If the email address is new, this method creates a new contact.
     *
     * @param string $email_address
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
     */
    public function setEmailAddress(string $email_address) : \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
    {
        $this->email_address = substr($email_address, 0, 50);
        return $this;
    }

    /**
     * The first name of the contact.
     * Max Length: 50
     *
     * @return string
     */
    public function getFirstName() : string
    {
        return $this->first_name;
    }

    /**
     *
     * @param string $first_name
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
     */
    public function setFirstName(string $first_name) : \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * The last name of the contact.
     * Max Length: 50
     *
     * @return string
     */
    public function getLastName() : string
    {
        return $this->last_name;
    }

    /**
     *
     * @param string $last_name
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
     */
    public function setLastName(string $last_name) : \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * The job title of the contact.
     * Max Length: 50
     *
     * @return string
     */
    public function getJobTitle() : string
    {
        return $this->job_title;
    }

    /**
     *
     * @param string $job_title
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
     */
    public function setJobTitle(string $job_title) : \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
    {
        $this->job_title = $job_title;
        return $this;
    }

    /**
     * The name of the company where the contact works.
     * Max Length: 50
     *
     * @return string
     */
    public function getCompanyName() : string
    {
        return $this->company_name;
    }

    /**
     *
     * @param string $company_name
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
     */
    public function setCompanyName(string $company_name) : \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
    {
        $this->company_name = $company_name;
        return $this;
    }

    /**
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
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
     */
    public function setPhoneNumber(string $phone_number) : \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
    {
        $this->phone_number = $phone_number;
        return $this;
    }

    /**
     * The month value for the contact's birthday.
     * Valid values are from 1 through 12.
     * You must use this property with birthday_month.
     *
     * @return int
     */
    public function getBirthdayMonth() : int
    {
        return intval($this->birthday_month);
    }

    /**
     *
     * @param int $birthday_month
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
     */
    public function setBirthdayMonth(int $birthday_month) : \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
    {
        $this->birthday_month = $birthday_month;
        return $this;
    }

    /**
     * The day value for the contact's birthday.
     * Valid values are from 1 through 12.
     * You must use this property with birthday_day.
     *
     * @return int
     */
    public function getBirthdayDay() : int
    {
        return intval($this->birthday_day);
    }

    /**
     *
     * @param int $birthday_day
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
     */
    public function setBirthdayDay(int $birthday_day) : \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
    {
        $this->birthday_day = $birthday_day;
        return $this;
    }

    /**
     * The anniversary date for the contact.
     * For example, this value could be the date when the contact first became a customer of an organization in Constant Contact.
     * Valid date formats are MM/DD/YYYY, M/D/YYYY, YYYY/MM/DD, YYYY/M/D, YYYY-MM-DD, YYYY-M-D,M-D-YYYY, or M-DD-YYYY.
     *
     * @return string
     */
    public function getAnniversary() : string
    {
        return $this->anniversary;
    }

    /**
     * Valid date formats are MM/DD/YYYY, M/D/YYYY, YYYY/MM/DD, YYYY/M/D, YYYY-MM-DD, YYYY-M-D,M-D-YYYY, or M-DD-YYYY.
     *
     * @param string $anniversary
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
     */
    public function setAnniversary(string $anniversary) : \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
    {
        $this->anniversary = date("Y-m-d",strtotime($anniversary));
        return $this;
    }

    /**
     * Array of up to 25 custom_field key value pairs (ContactCustomField objects).
     *
     * @return array[\Cloudcogs\ConstantContact\Api\Contacts\ContactCustomField]
     */
    public function getCustomFields() : array
    {
        return $this->custom_fields;
    }

    /**
     *
     * @param ContactCustomField $ContactCustomField
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
     */
    public function addCustomField(ContactCustomField $ContactCustomField) : \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
    {
        $this->custom_fields[] = $ContactCustomField;
        return $this;
    }

    /**
     *
     * A contact can have 1 street address.
     *
     * @return \Cloudcogs\ConstantContact\Api\Contacts\StreetAddress
     */
    public function getStreetAddress() : \Cloudcogs\ConstantContact\Api\Contacts\StreetAddress
    {
        return $this->street_addresses;
    }

    /**
     *
     * @param StreetAddress $StreetAddress
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
     */
    public function setStreetAddress(StreetAddress $StreetAddress) : \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
    {
        $this->street_addresses = $StreetAddress;
        return $this;
    }

    /**
     * Array of list_id's to which the contact is subscribed, up to a maximum of 50.
     *
     * @return array
     */
    public function getListMemberships() : array
    {
        return $this->list_memberships;
    }

    /**
     *
     * @param string $list_memberships
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
     */
    public function addListMemberships(string $list_memberships) : \Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput
    {
        $list = explode(",", $list_memberships);

        if (!$this->offsetExists('list_memberships')) $this->list_memberships = [];

        $this->list_memberships = array_merge($this->list_memberships, $list);
        return $this;
    }
}

