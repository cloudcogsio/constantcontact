<?php
namespace Cloudcogs\ConstantContact\Api\Contacts;

use Cloudcogs\ConstantContact\Client;
use GuzzleHttp\RequestOptions;
use Cloudcogs\ConstantContact\Api\Contacts\Exception\InvalidContactSubResourceString;
use Cloudcogs\ConstantContact\Api\Contacts\Exception\InvalidContact;
use Cloudcogs\ConstantContact\Api\AbstractAPI;

class GetContact extends AbstractAPI
{
    const SERVICE_URI = "/contacts";

    const INCLUDE_CUSTOM_FIELDS = 'custom_fields';
    const INCLUDE_LIST_MEMBERSHIPS = 'list_memberships';
    const INCLUDE_PHONE_NUMBERS = 'phone_numbers';
    const INCLUDE_STREET_ADDRESSES = 'street_addresses';
    const INCLUDE_TAGGINGS = 'taggings';

    protected $contact_id;
    protected $include = [];

    /**
     *
     * @param Client $Client
     * @param string $contact_id Unique ID of contact to GET
     * @param string $include
     * @see \Cloudcogs\ConstantContact\Api\Contacts\GetContact::addIncludeContactSubResources()
     */
    public function __construct(Client $Client, string $contact_id = null,  string $include = null)
    {
        $this->service_uri = self::SERVICE_URI;
        parent::__construct($Client);

        $this->contact_id = $contact_id;
        $this->addIncludeContactSubResources($include);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Cloudcogs\ConstantContact\Api\AbstractAPI::preProcessHTTPClient()
     */
    protected function preProcessHTTPClient()
    {
        $this->serviceURL = $this->serviceURL."/".$this->contact_id;

        $queryData = [];
        if ($this->include) $queryData['include'] = implode(",", $this->include);

        $this->setHTTPOption(RequestOptions::QUERY, $queryData);
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
                $ContactResource = new ContactResource((array) $contact);
                return $ContactResource;
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
        return $this->get();
    }

    /**
     *
     * @param string $include
     * Use include to specify which contact sub-resources to include in the response. Use a comma to separate multiple sub-resources.
     * Valid values: custom_fields, list_memberships, phone_numbers, street_addresses, and taggings
     *
     * @throws InvalidContactSubResourceString
     * @return \Cloudcogs\ConstantContact\Api\AbstractAPI
     */
    public function addIncludeContactSubResources(string $include = null) : \Cloudcogs\ConstantContact\Api\AbstractAPI
    {
        if ($include == null) return $this;

        $include_parts = explode(",", $include);
        foreach ($include_parts as $sub_resource)
        {
            $sub_resource = trim($sub_resource);
            switch ($sub_resource)
            {
                case self::INCLUDE_CUSTOM_FIELDS:
                case self::INCLUDE_LIST_MEMBERSHIPS:
                case self::INCLUDE_PHONE_NUMBERS:
                case self::INCLUDE_STREET_ADDRESSES:
                case self::INCLUDE_TAGGINGS:
                    if (!in_array($sub_resource, $this->include))
                        $this->include[] = $sub_resource;
                        break;

                default:
                    throw new InvalidContactSubResourceString($sub_resource);
            }
        }

        return $this;
    }
}