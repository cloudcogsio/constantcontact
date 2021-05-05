<?php
namespace Cloudcogs\ConstantContact\Api\ContactLists;

use Cloudcogs\ConstantContact\Api\ContactLists\PutList;
use Cloudcogs\ConstantContact\Client;
use GuzzleHttp\RequestOptions;
use Cloudcogs\ConstantContact\Api\ContactLists\Exception\CreateListException;

class PostList extends PutList
{
    public function __construct(Client $Client)
    {
        $this->service_uri = self::SERVICE_URI;
        parent::__construct($Client);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Cloudcogs\ConstantContact\Api\ContactLists\PutList::preProcessHTTPClient()
     */
    protected function preProcessHTTPClient()
    {
        $this->setHTTPOption(RequestOptions::BODY, (string) $this->ListInput);
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
            $list = json_decode($body);
            if ($list->list_id)
            {
                return new ContactList((array) $list);
            }

            throw new CreateListException();
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