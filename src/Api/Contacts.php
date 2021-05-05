<?php
namespace Cloudcogs\ConstantContact\Api;

use Cloudcogs\ConstantContact\Client;
use Cloudcogs\ConstantContact\Api\Contacts\GetContact;
use Cloudcogs\ConstantContact\Api\Contacts\GetContacts;
use Cloudcogs\ConstantContact\Api\Contacts\ContactResource;
use Cloudcogs\ConstantContact\Api\Contacts\PostContact;
use Cloudcogs\ConstantContact\Api\Contacts\PutContact;
use Cloudcogs\ConstantContact\Api\Contacts\CreateOrUpdateContact;
use Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput;
use Cloudcogs\ConstantContact\Api\Contacts\DeleteContact;

class Contacts
{
    protected $Client;
    protected $GetContact = [];
    protected $GetContacts;

    public function __construct(Client $Client)
    {
        $this->Client = $Client;
    }

    /**
     * This endpoint GETs a specific contact resource (contact_id). Use the include query parameter to add any of the available contact sub-resources to the response payload.
     *
     * @param string $contact_id
     * @param string $include
     * @return \Cloudcogs\ConstantContact\Api\Contacts\GetContact
     */
    public function GetContact(string $contact_id, string $include = null) : \Cloudcogs\ConstantContact\Api\Contacts\GetContact
    {
        if (!isset($this->GetContact[$contact_id]))
        {
            $this->GetContact[$contact_id] = new GetContact($this->Client, $contact_id, $include);
        }

        return $this->GetContact[$contact_id];
    }

    /**
     * Use this method to return a collection of contacts.
     * Use the query parameters to search for contacts that match specific criteria.
     *
     * For example, you can search by the contact's email address, status, lists memberships, segment_id, tags and updated_after date.
     * Use the limit query parameter to limit the number of results returned per page.
     * Use the include query parameter to include contact sub-resources in the response and include_count to include the total number of contacts that meet your specified search criteria.
     * By default, this method returns all contacts that are not deleted.
     * Use the status query parameter with the value all to return all contacts including deleted contacts.
     *
     * @param string $status - Use the status query parameter to search for contacts by status.
     * @param string $email - Use the email query parameter to search for a contact using a specific email address.
     * @param string $lists - Use the lists query parameter to search for contacts that are members of one or more specified lists.
     * @param string $segment_id - Use to get contacts that meet the segment criteria for a single specified segment_id.
     * @param string $tags - Use to get contact details for up to 50 specified tags. Use a comma to separate each tag_id.
     * @param string $updated_after - Use updated_after to search for contacts that have been updated after the date you specify; accepts ISO-8601 formatted dates (Ex. YYYY-MM-DD)
     * @param string $include - Use include to specify which contact sub-resources to include in the response. Use a comma to separate multiple sub-resources. Valid values: custom_fields, list_memberships, taggings, phone_numbers, street_addresses.
     * @param bool $include_count - Set include_count=true to include the total number of contacts (contacts_count) that meet all search criteria in the response body.
     * @param int $limit - Specifies the number of results displayed per page of output in the response, from 1 - 500, default = 50.
     * @return \Cloudcogs\ConstantContact\Api\Contacts\GetContacts
     */
    public function GetContacts(string $status = "all", string $email = null, string $lists = null, string $segment_id = null, string $tags = null, string $updated_after = null, string $include = null, bool $include_count = true, int $limit = 50) : \Cloudcogs\ConstantContact\Api\Contacts\GetContacts
    {
        if (!$this->GetContacts)
        {
            $this->GetContacts = new GetContacts($this->Client, $status, $email, $lists, $segment_id, $tags, $updated_after, $include, $include_count, $limit);
        }

        return $this->GetContacts;
    }

    /**
     * Creates a new contact resource; you must include the create_source property and at least one of the following properties when creating a new contact:
     * first_name, last_name, or email_address (email_address must be unique for each contact).
     *
     * @param ContactResource $Contact
     * @return \Cloudcogs\ConstantContact\Api\Contacts\PostContact
     */
    public function PostContact(ContactResource $Contact) : \Cloudcogs\ConstantContact\Api\Contacts\PostContact
    {
        return new PostContact($this->Client, $Contact);
    }

    /**
     * The PUT method updates an existing contact.
     * You must include the update_source property in the PUT request payload.
     * To restore a deleted contact you must specify the update_source as Account.
     * When updating any resource using PUT, all properties are updated, overwriting all previous values.
     * Any properties left blank or not included in the request are overwritten with null value - however this does not apply to contact subresources.
     * Add or change any of the subresources by including them in the PUT request payload.
     * Omitted subresources are not overwritten with null.
     * If the contact being updated is deleted, the contact will be revived.
     *
     * @param ContactResource $Contact
     * @param string $contact_id
     * @param string $update_source
     * @return \Cloudcogs\ConstantContact\Api\Contacts\PutContact
     */
    public function PutContact(ContactResource $Contact, string $contact_id, string $update_source = ContactResource::SOURCE_ACCOUNT) : \Cloudcogs\ConstantContact\Api\Contacts\PutContact
    {
        $Contact->setUpdateSource($update_source);
        return new PutContact($this->Client, $Contact, $contact_id);
    }

    /**
     * @see https://v3.developer.constantcontact.com/api_reference/index.html#!/Contacts/createOrUpdateContact
     *
     * @param ContactCreateOrUpdateInput $Contact
     * @return \Cloudcogs\ConstantContact\Api\Contacts\CreateOrUpdateContact
     */
    public function CreateOrUpdateContact(ContactCreateOrUpdateInput $Contact) : \Cloudcogs\ConstantContact\Api\Contacts\CreateOrUpdateContact
    {
        return new CreateOrUpdateContact($this->Client, $Contact);
    }

    /**
     * Deletes the contact identified by the contact_id path parameter.
     * Deleted contacts won't receive email from you, and they don't count as active contacts.
     * Unlike unsubscribed contacts, deleted contacts can be revived, or added back to an account.
     *
     * @param string $contact_id
     * @throws \Exception
     * @return \Cloudcogs\ConstantContact\Api\Contacts\DeleteContact
     */
    public function DeleteContact(string $contact_id) : \Cloudcogs\ConstantContact\Api\Contacts\DeleteContact
    {
        return new DeleteContact($this->Client, $contact_id);
    }
}

