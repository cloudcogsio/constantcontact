<?php
namespace Cloudcogs\ConstantContact\Api\Contacts;

use Cloudcogs\ConstantContact\Api\AbstractAPI;
use Cloudcogs\ConstantContact\Client;

class DeleteContact extends AbstractAPI
{
    const SERVICE_URI = "/contacts";

    protected $contact_id;

    /**
     *
     * @param Client $Client
     * @param string $contact_id
     */
    public function __construct(Client $Client, string $contact_id)
    {
        $this->service_uri = self::SERVICE_URI;
        parent::__construct($Client);

        $this->contact_id = $contact_id;
    }

    public function send()
    {
        return $this->delete();
    }

    protected function preProcessHTTPClient()
    {
        $this->serviceURL = $this->serviceURL."/".$this->contact_id;
    }

    protected function handleResponse()
    {
        $body = $this->HTTPResponse->getBody();
        $statusCode = $this->HTTPResponse->getStatusCode();

        if ($statusCode == 204)
        {
            return true;
        }
        else
        {
            $this->ThrowException($statusCode);
        }
    }
}