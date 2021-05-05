<?php
require_once 'demo_common.php';

/** @var $Client \Cloudcogs\ConstantContact\Client **/

// Update a list (requires the list id to be known). See `GetListsDemo.php` to retrieve lists and obtain a list_id.
try {
    $list_id = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";

    $ContactListsAPI = $Client->ContactLists();

    $UpdatedList = $ContactListsAPI->PutList($list_id)
        ->setDescription("Updated description")
        ->setName("New List Name")
        ->setFavorite(false)
        ->send();

        print "`".$UpdatedList->getName()."` was updated at ".$UpdatedList->getUpdatedAt()."\n";

}
// Expired access token, refresh
catch (Exception $e)
{
    if ($e->getCode() == 401)
    {
        print "Refreshing Access Token\nPlease execute again.";
        $Client->refreshAccessToken();
    }
    else
    {
        throw $e;
    }
}