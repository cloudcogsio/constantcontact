<?php
namespace Cloudcogs\ConstantContact\Api\Contacts;

use GuzzleHttp\RequestOptions;
use Cloudcogs\ConstantContact\Api\Contacts\Exception\InvalidContact;
use Cloudcogs\ConstantContact\Api\AbstractAPI;
use Cloudcogs\ConstantContact\Client;

class CreateOrUpdateContact extends AbstractAPI
{
    const SERVICE_URI = "/contacts/sign_up_form";

    protected $Contact;

    /**
     * Use this method to create a new contact or update an existing contact.
     * This method uses the email_address string value you include in the request body to determine if it should create an new contact or update an existing contact.
     *
     * Updates to existing contacts are partial updates.
     * This method only updates the contact properties you include in the request body.
     * Updates append new contact lists or custom fields to the existing list_memberships or custom_fields arrays.
     *
     * @param Client $Client
     * @param ContactCreateOrUpdateInput $Contact
     * @see https://v3.developer.constantcontact.com/api_reference/index.html#!/Contacts/createOrUpdateContact
     */
    public function __construct(Client $Client, ContactCreateOrUpdateInput $Contact)
    {
        $this->service_uri = self::SERVICE_URI;
        parent::__construct($Client);

        $this->Contact = $Contact;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Cloudcogs\ConstantContact\Api\ContactLists\PutList::preProcessHTTPClient()
     */
    protected function preProcessHTTPClient()
    {
        if (!$this->Contact->offsetExists('list_memberships')) throw new InvalidContact();
        if (!$this->Contact->offsetExists('email_address')) throw new InvalidContact();

        $this->setHTTPOption(RequestOptions::BODY, (string) $this->Contact);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Cloudcogs\ConstantContact\Api\ContactLists\PutList::handleResponse()
     */
    protected function handleResponse()
    {
        $body = $this->HTTPResponse->getBody();
        $statusCode = $this->HTTPResponse->getStatusCode();

        if ($statusCode == 200 || $statusCode == 201)
        {
            $contact = json_decode($body);
            if ($contact->contact_id)
            {
                return new ContactCreateOrUpdateResponse((array) $contact);
            }

            throw new InvalidContact();
        }
        else
        {
            $this->ThrowException($statusCode);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \Cloudcogs\ConstantContact\Api\ContactLists\PutList::send()
     */
    public function send()
    {
        return $this->post();
    }
}