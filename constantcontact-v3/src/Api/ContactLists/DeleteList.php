<?php
namespace Cloudcogs\ConstantContact\Api\ContactLists;

use Cloudcogs\ConstantContact\Api\AbstractAPI;
use Cloudcogs\ConstantContact\Client;
use Cloudcogs\ConstantContact\Api\ContactLists\Exception\InvalidActivityDeleteListResponse;

class DeleteList extends AbstractAPI
{
    const SERVICE_URI = "/contact_lists";

    protected $list_id;

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
    }

    public function send()
    {
        return $this->delete();
    }

    protected function preProcessHTTPClient()
    {
        $this->serviceURL = $this->serviceURL."/".$this->list_id;
    }

    protected function handleResponse()
    {
        $body = $this->HTTPResponse->getBody();
        $statusCode = $this->HTTPResponse->getStatusCode();

        if ($statusCode == 202)
        {
            $response = json_decode($body);
            if ($response->activity_id)
            {
                return new ActivityDeleteListResponse((array) $response);
            }

            throw new InvalidActivityDeleteListResponse();
        }
        else
        {
            $this->ThrowException($statusCode);
        }
    }
}