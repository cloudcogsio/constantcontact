<?php
namespace Cloudcogs\ConstantContact\Api;

use Cloudcogs\ConstantContact\Api\ContactLists\GetLists;
use Cloudcogs\ConstantContact\Api\ContactLists\GetList;
use Cloudcogs\ConstantContact\Client;
use Cloudcogs\ConstantContact\Api\ContactLists\PutList;
use Cloudcogs\ConstantContact\Api\ContactLists\PostList;
use Cloudcogs\ConstantContact\Api\ContactLists\DeleteList;

class ContactLists
{
    protected $GetLists;
    protected $GetList = [];
    protected $Client;

    public function __construct(Client $Client)
    {
        $this->Client = $Client;
    }

    /**
     *
     * @return \Cloudcogs\ConstantContact\Api\ContactLists\GetLists
     */
    public function GetLists() : \Cloudcogs\ConstantContact\Api\ContactLists\GetLists
    {
        if (!$this->GetLists)
        {
            $this->GetLists = new GetLists($this->Client);
        }

        return $this->GetLists;
    }

    /**
     *
     * @param string $list_id
     * @return \Cloudcogs\ConstantContact\Api\ContactLists\GetList
     */
    public function GetList(string $list_id) : \Cloudcogs\ConstantContact\Api\ContactLists\GetList
    {
        if (!isset($this->GetList[$list_id]))
        {
            $this->GetList[$list_id] = new GetList($this->Client, $list_id);
        }

        return $this->GetList[$list_id];
    }

    /**
     *
     * @param string $list_id
     * @return \Cloudcogs\ConstantContact\Api\ContactLists\PutList
     */
    public function PutList(string $list_id) : \Cloudcogs\ConstantContact\Api\ContactLists\PutList
    {
        return new PutList($this->Client, $list_id);
    }

    /**
     *
     * @return \Cloudcogs\ConstantContact\Api\ContactLists\PostList
     */
    public function PostList() : \Cloudcogs\ConstantContact\Api\ContactLists\PostList
    {
        return new PostList($this->Client);
    }

    /**
     *
     * @param string $list_id
     * @return \Cloudcogs\ConstantContact\Api\ContactLists\DeleteList
     */
    public function DeleteList(string $list_id) : \Cloudcogs\ConstantContact\Api\ContactLists\DeleteList
    {
        return new DeleteList($this->Client, $list_id);
    }
}

