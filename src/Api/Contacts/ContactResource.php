<?php
namespace Cloudcogs\ConstantContact\Api\Contacts;

use Cloudcogs\ConstantContact\Api\AbstractSchema;
use Cloudcogs\ConstantContact\Api\Contacts\Exception\InvalidCreateSource;
use Cloudcogs\ConstantContact\Api\Contacts\Exception\InvalidUpdateSource;

class ContactResource extends AbstractSchema
{
    const SOURCE_ACCOUNT = 'Account';
    const SOURCE_CONTACT = 'Contact';

    public function __construct(array $data = null)
    {
        parent::__construct(($data == null)?[]:$data);

        if ($data != null)
        {
            $this->hydrate((object) $data);
        }
    }

    /**
     * Unique ID for each contact resource
     * read only
     *
     * @return string
     */
    public function getContactId() : string
    {
        return $this->contact_id;
    }

    /**
     *
     * @return EmailAddress
     */
    public function getEmailAddress() : EmailAddress
    {
        return $this->email_address;
    }

    /**
     *
     * @param EmailAddress $EmailAddress
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
     */
    public function setEmailAddress(EmailAddress $EmailAddress) : \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
    {
        $this->email_address = $EmailAddress;
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
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
     */
    public function setFirstName(string $first_name) : \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
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
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
     */
    public function setLastName(string $last_name) : \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
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
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
     */
    public function setJobTitle(string $job_title) : \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
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
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
     */
    public function setCompanyName(string $company_name) : \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
    {
        $this->company_name = $company_name;
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
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
     */
    public function setBirthdayMonth(int $birthday_month) : \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
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
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
     */
    public function setBirthdayDay(int $birthday_day) : \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
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
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
     */
    public function setAnniversary(string $anniversary) : \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
    {
        $this->anniversary = date("Y-m-d",strtotime($anniversary));
        return $this;
    }

    /**
     * Identifies who last updated the contact; valid values are Contact or Account
     * Enum: [Account, Contact]
     *
     * @return string
     */
    public function getUpdateSource() : string
    {
        return $this->update_source;
    }

    /**
     * Required for PutContact
     *
     * @param string $update_source
     * @throws InvalidUpdateSource
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
     */
    public function setUpdateSource(string $update_source) : \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
    {
        switch ($update_source)
        {
            case self::SOURCE_ACCOUNT:
            case self::SOURCE_CONTACT:
                $this->update_source = $update_source;
                return $this;
            default:
                throw new InvalidUpdateSource($update_source);
        }
    }

    /**
     * Describes who added the contact; valid values are Contact or Account.
     * Your integration must accurately identify create_source for compliance reasons; value is set when contact is created.
     * Enum: [Account, Contact]
     *
     * @return string
     */
    public function getCreateSource() : string
    {
        return $this->create_source;
    }

    /**
     *
     * @param string $create_source
     * @throws InvalidCreateSource
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
     */
    public function setCreateSource(string $create_source) : \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
    {
        switch ($create_source)
        {
            case self::SOURCE_ACCOUNT:
            case self::SOURCE_CONTACT:
                $this->create_source = $create_source;
                return $this;
            default:
                throw new InvalidCreateSource($create_source);
        }
    }

    /**
     * System generated date and time that the resource was created, in ISO-8601 format.
     *
     * @return string
     */
    public function getCreatedAt() : string
    {
        return $this->created_at;
    }

    /**
     * System generated date and time that the contact was last updated, in ISO-8601 format.
     *
     * @return string
     */
    public function getUpdatedAt() : string
    {
        return $this->updated_at;
    }

    /**
     * For deleted contacts (email_address contains opt_out_source and opt_out_date), shows the date of deletion.
     *
     * @return string
     */
    public function getDeletedAt() : string
    {
        return $this->deleted_at;
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
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
     */
    public function addCustomField(ContactCustomField $ContactCustomField) : \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
    {
        $this->custom_fields[] = $ContactCustomField;
        return $this;
    }

    /**
     * Array of phone_numbers subresources.
     * A contact can have up to 2 phone numbers.
     *
     * @return array[\Cloudcogs\ConstantContact\Api\Contacts\PhoneNumber]
     */
    public function getPhoneNumbers() : array
    {
        return $this->phone_numbers;
    }

    /**
     *
     * @param PhoneNumber $PhoneNumber
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
     */
    public function addPhoneNumber(PhoneNumber $PhoneNumber) : \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
    {
        $this->phone_numbers[] = $PhoneNumber;
        return $this;
    }

    /**
     * Array of street_addresses subresources.
     * A contact can have 1 street address.
     *
     * @return array[\Cloudcogs\ConstantContact\Api\Contacts\StreetAddress]
     */
    public function getStreetAddresses() : array
    {
        return $this->street_addresses;
    }

    /**
     *
     * @param StreetAddress $StreetAddress
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
     */
    public function addStreetAddress(StreetAddress $StreetAddress) : \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
    {
        $this->street_addresses[] = $StreetAddress;
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
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
     */
    public function addListMemberships(string $list_memberships) : \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
    {
        $list = explode(",", $list_memberships);

        if (!$this->offsetExists('list_memberships')) $this->list_memberships = [];

        $this->list_memberships = array_merge($this->list_memberships, $list);
        return $this;
    }

    /**
     * Array of tags (tag_id) assigned to the contact, up to a maximum of 50.
     *
     * @return array
     */
    public function getTaggings() : array
    {
        return $this->taggings;
    }

    /**
     *
     * @param string $taggings
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
     */
    public function addTaggings(string $taggings) : \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
    {
        $list = explode(",", $taggings);

        if (!$this->offsetExists('taggings')) $this->taggings = [];

        $this->taggings = array_merge($this->taggings, $list);
        return $this;
    }

    public function hydrate($contact)
    {
        $this->email_address = new EmailAddress((array) $contact->email_address);

        // Custom Fields
        $custom_fields = @$contact->custom_fields;
        if ($custom_fields)
        {
            foreach ($custom_fields as $i=>$custom_field)
            {
                $ContactCustomField = new ContactCustomField((array) $custom_field);
                $custom_fields[$i] = $ContactCustomField;
            }
            $this->custom_fields = $custom_fields;
        }

        // Phone Numbers
        $phone_numbers = @$contact->phone_numbers;
        if ($phone_numbers)
        {
            foreach ($phone_numbers as $j=>$phone_number)
            {
                $PhoneNumber = new PhoneNumber((array) $phone_number);
                $phone_numbers[$j] = $PhoneNumber;
            }
            $this->phone_numbers = $phone_numbers;
        }

        // Street Addresses
        $street_addresses = @$contact->street_addresses;
        if ($street_addresses)
        {
            foreach ($street_addresses as $k=>$street_address)
            {
                $StreetAddress = new StreetAddress((array) $street_address);
                $street_addresses[$k] = $StreetAddress;
            }
            $this->street_addresses = $street_addresses;
        }

        return $this;
    }
}

