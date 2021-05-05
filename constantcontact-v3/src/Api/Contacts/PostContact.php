<?php
namespace Cloudcogs\ConstantContact\Api\Contacts;

use GuzzleHttp\RequestOptions;
use Cloudcogs\ConstantContact\Api\Contacts\Exception\InvalidContact;
use Cloudcogs\ConstantContact\Api\Contacts\Exception\InvalidCreateSource;

class PostContact extends PutContact
{
    /**
     *
     * {@inheritDoc}
     * @see \Cloudcogs\ConstantContact\Api\ContactLists\PutList::preProcessHTTPClient()
     */
    protected function preProcessHTTPClient()
    {
        if (!$this->Contact->offsetExists('create_source')) throw new InvalidCreateSource('NOT SET');
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

        if ($statusCode == 201)
        {
            $contact = json_decode($body);
            if ($contact->contact_id)
            {
                return new ContactResource((array) $contact);
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