<?php
namespace Cloudcogs\ConstantContact\Api\ContactLists;

use Cloudcogs\ConstantContact\Client;
use GuzzleHttp\RequestOptions;

class GetLists extends GetList
{
    protected $limit;
    protected $include_count;
    protected $lists = [];

    /**
     *
     * @param Client $Client
     * @param number $limit
     * @param bool $include_count
     * @param string $include_membership_count
     */
    public function __construct(Client $Client, $limit = 50, bool $include_count = false, string $include_membership_count = "all")
    {
        parent::__construct($Client, null, $include_membership_count);

        $this->setLimit($limit);
        $this->setIncludeCount($include_count);
    }

    /**
     *
     * @param number $limit - Min 1, Max 1000
     *
     * @return \Cloudcogs\ConstantContact\Api\ContactLists\GetLists
     */
    public function setLimit($limit = 50) : \Cloudcogs\ConstantContact\Api\ContactLists\GetLists
    {
        if ($limit < 1) $limit = 1;
        if ($limit > 1000) $limit = 1000;

        $this->limit = $limit;

        return $this;
    }

    /**
     *
     * @param boolean $on
     * @return \Cloudcogs\ConstantContact\Api\ContactLists\GetLists
     */
    public function setIncludeCount($on = false) : \Cloudcogs\ConstantContact\Api\ContactLists\GetLists
    {
        $this->include_count = $on;

        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Cloudcogs\ConstantContact\Api\ContactLists\GetList::preProcessHTTPClient()
     */
    protected function preProcessHTTPClient()
    {
        $this->setHTTPOption(RequestOptions::QUERY, [
            'limit' => $this->limit,
            'include_count' => $this->include_count,
            'include_membership_count' => $this->include_membership_count
        ]);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Cloudcogs\ConstantContact\Api\ContactLists\GetList::handleResponse()
     */
    protected function handleResponse()
    {
        $body = $this->HTTPResponse->getBody();
        $statusCode = $this->HTTPResponse->getStatusCode();

        if ($statusCode == 200)
        {
            $list = json_decode($body);
            if ($list->lists)
            {
                foreach ($list->lists as $i=>$ContactList)
                {
                    $list->lists[$i] = new ContactList((array) $ContactList);
                }

                $this->lists = $list->lists;
            }

            return $this;
        }
        else
        {
            $this->ThrowException($statusCode);
        }
    }

    /**
     *
     * @return array
     */
    public function lists() : array
    {
        return $this->lists;
    }

    /**
     *
     * @param string $name
     * @return \Cloudcogs\ConstantContact\Api\ContactLists\ContactList | null
     */
    public function getListByName($name)
    {
        foreach ($this->lists as $list)
        {
            if ($list->name == $name) return $list;
        }

        return null;
    }
}