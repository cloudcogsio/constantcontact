<?php
namespace Cloudcogs\ConstantContact\Api\ContactLists;

use Cloudcogs\ConstantContact\Api\AbstractAPI;
use Cloudcogs\ConstantContact\Client;
use GuzzleHttp\RequestOptions;
use Cloudcogs\ConstantContact\Api\ContactLists\Exception\InvalidList;

class PutList extends AbstractAPI
{
    const SERVICE_URI = "/contact_lists";

    protected $list_id;
    protected $ListInput;

    /**
     *
     * @param Client $Client
     * @param string $list_id
     */
    public function __construct(Client $Client, string $list_id = null)
    {
        $this->service_uri = self::SERVICE_URI;
        parent::__construct($Client);

        $this->list_id = $list_id;
        $this->ListInput = new ListInput();
    }

    /**
     *
     * {@inheritDoc}
     * @see \Cloudcogs\ConstantContact\Api\AbstractAPI::preProcessHTTPClient()
     */
    protected function preProcessHTTPClient()
    {
        $this->serviceURL = $this->serviceURL."/".$this->list_id;
        $this->setHTTPOption(RequestOptions::BODY, (string) $this->ListInput);
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
            $list = json_decode($body);
            if ($list->list_id)
            {
                return new ContactList((array) $list);
            }

            throw new InvalidList($this->list_id);
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

    /**
     * The name given to the contact list
     *
     * @param string $name
     * @return \Cloudcogs\ConstantContact\Api\ContactLists\PutList
     */
    public function setName(string $name) : \Cloudcogs\ConstantContact\Api\ContactLists\PutList
    {
        $this->ListInput->setName($name);

        return $this;
    }

    /**
     * Text describing the list.
     *
     * @param string $description
     * @return \Cloudcogs\ConstantContact\Api\ContactLists\PutList
     */
    public function setDescription(string $description) : \Cloudcogs\ConstantContact\Api\ContactLists\PutList
    {
        $this->ListInput->setDescription($description);

        return $this;
    }

    /**
     * Identifies whether or not the account has favorited the contact list.
     *
     * @param bool $favorite
     * @return \Cloudcogs\ConstantContact\Api\ContactLists\PutList
     */
    public function setFavorite(bool $favorite) : \Cloudcogs\ConstantContact\Api\ContactLists\PutList
    {
        $this->ListInput->setFavorite($favorite);

        return $this;
    }

    /**
     * Overload `PutList` to call operations on wrapped `ListInput` object
     *
     * @param string $method
     * @param array $arguments
     * @throws \Exception
     * @return \Cloudcogs\ConstantContact\Api\ContactLists\PutList
     */
    public function __call($method, $arguments)
    {
        if ($this->ListInput instanceof \Cloudcogs\ConstantContact\Api\ContactLists\ListInput)
        {
            call_user_func_array([$this->ListInput, $method], $arguments);

            return $this;
        }

        throw new \Exception('Requested Method does not exist!');
    }
}