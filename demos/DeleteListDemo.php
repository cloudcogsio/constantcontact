<?php

require_once 'demo_common.php';

/** @var $Client \Cloudcogs\ConstantContact\Client **/

// Delete a list (requires the list id to be known). See `GetListsDemo.php` to retrieve lists and obtain a list_id.
try {
    $list_id = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";

    $ContactListsAPI = $Client->ContactLists();

    $DeletedActivityListResponse = $ContactListsAPI->DeleteList($list_id)->send();

    print_r($DeletedActivityListResponse);

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