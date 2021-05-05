<?php
require_once 'demo_common.php';

/** @var $Client \Cloudcogs\ConstantContact\Client **/

// Create a new list
try {

    $ContactListsAPI = $Client->ContactLists();

    $MyNewList = $ContactListsAPI->PostList()
        ->setName("My New List")
        ->setDescription("My new list created via API")
        ->setFavorite(true)
        ->send();

    print "`".$MyNewList->getName()."` was created at ".$MyNewList->getCreatedAt()."\n";

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