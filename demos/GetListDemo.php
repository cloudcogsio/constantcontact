<?php
require_once 'demo_common.php';

/** @var $Client \Cloudcogs\ConstantContact\Client **/

// Get a single list
try {

    // Retrieving a single list requires the list id to be known.
    $list_id = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";

    $list = $Client->ContactLists()->GetList($list_id)->send();
    print "`".$list->getName()."` has ".$list->getMembershipCount()." member(s). Created: ".$list->getCreatedAt()."\n";

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