<?php
namespace Cloudcogs\ConstantContact\Api\ContactLists;

use Cloudcogs\ConstantContact\Api\ContactLists\Exception\InvalidMembershipCountValue;
use Cloudcogs\ConstantContact\Api\AbstractAPI;
use Cloudcogs\ConstantContact\Client;
use GuzzleHttp\RequestOptions;
use Cloudcogs\ConstantContact\Api\ContactLists\Exception\InvalidList;

class GetList extends AbstractAPI
{
    const SERVICE_URI = "/contact_lists";

    protected $list_id;
    protected $include_membership_count;

    /**
     *
     * @param Client $Client
     * @param string $list_id
     * @param string $include_membership_count
     */
    public function __construct(Client $Client, string $list_id = null,  string $include_membership_count = "all")
    {
        $this->service_uri = self::SERVICE_URI;
        parent::__construct($Client);

        $this->list_id = $list_id;
        $this->setIncludeMembershipCount($include_membership_count);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Cloudcogs\ConstantContact\Api\AbstractAPI::preProcessHTTPClient()
     */
    protected function preProcessHTTPClient()
    {
        $this->serviceURL = $this->serviceURL."/".$this->list_id;

        $this->setHTTPOption(RequestOptions::QUERY, [
            'include_membership_count' => $this->include_membership_count
        ]);
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
        return $this->get();
    }

    /**
     *
     * @param string $include
     * @throws InvalidMembershipCountValue
     *
     * @return \Cloudcogs\ConstantContact\Api\ContactLists\GetLists | \Cloudcogs\ConstantContact\Api\ContactLists\GetList
     */
    public function setIncludeMembershipCount($include = "all") : \Cloudcogs\ConstantContact\Api\AbstractAPI
    {
        switch ($include)
        {
            case "all":
            case "active":
                $this->include_membership_count = $include;
                break;

            default:
                throw new InvalidMembershipCountValue($include);
        }

        return $this;
    }
}