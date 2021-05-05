<?php
namespace Cloudcogs\ConstantContact\Api\Contacts;

use Cloudcogs\ConstantContact\Client;
use GuzzleHttp\RequestOptions;
use Cloudcogs\ConstantContact\Api\Contacts\ContactResource;
use Cloudcogs\ConstantContact\Api\Contacts\Exception\InvalidContact;
use Cloudcogs\ConstantContact\Api\AbstractAPI;
use Cloudcogs\ConstantContact\Api\Contacts\Exception\InvalidUpdateSource;

class PutContact extends AbstractAPI
{
    const SERVICE_URI = "/contacts";

    protected $contact_id;
    protected $Contact;

    /**
     *
     * @param Client $Client
     * @param ContactResource $Contact
     * @param string $contact_id
     */
    public function __construct(Client $Client, ContactResource $Contact, string $contact_id = null)
    {
        $this->service_uri = self::SERVICE_URI;
        parent::__construct($Client);

        if ($contact_id != null)
        {
            $this->contact_id = $contact_id;
        }

        $this->Contact = $Contact;
    }

    /**
     * Proxy to ContactResource
     *
     * @return \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
     */
    public function Contact() : \Cloudcogs\ConstantContact\Api\Contacts\ContactResource
    {
        return $this->Contact;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Cloudcogs\ConstantContact\Api\AbstractAPI::preProcessHTTPClient()
     */
    protected function preProcessHTTPClient()
    {
        if (!$this->Contact->offsetExists('update_source')) throw new InvalidUpdateSource('NOT SET');

        $this->serviceURL = $this->serviceURL."/".$this->contact_id;
        $this->setHTTPOption(RequestOptions::BODY, (string) $this->Contact);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Cloudcogs\ConstantContact\Api\AbstractAPI::handleResponse()
     */
    protected function handleResponse()
    {
        $body = $this->HTTPResponse->getBody();
        $statusCode = $this->HTTPResponse->getStatusCode();

        if ($statusCode == 200)
        {
            $contact = json_decode($body);
            if ($contact->contact_id)
            {
                return new ContactResource((array) $contact);
            }

            throw new InvalidContact($this->contact_id);
        }
        else
        {
            $this->ThrowException($statusCode);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \Cloudcogs\ConstantContact\Api\AbstractAPI::send()
     */
    public function send()
    {
        return $this->put();
    }
}