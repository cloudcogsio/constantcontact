<?php

require_once 'demo_common.php';

use Cloudcogs\ConstantContact\Api\ContactLists\GetLists;

/** @var $Client \Cloudcogs\ConstantContact\Client **/

// Get lists
try {

    $GetLists = $Client->ContactLists()->GetLists()->setLimit(50);
    $GetLists->send();

    // Array of \Cloudcogs\ConstantContact\Api\ContactLists\ContactList objects
    $MyLists = $GetLists->lists();

    /** @var $List \Cloudcogs\ConstantContact\Api\ContactLists\ContactList **/
    foreach ($MyLists as $List)
    {
        print "List `".$List->getName()."` has ".$List->getMembershipCount()." members\nID: ".$List->getListId()."\n\n";
    }

    // Get a list named `General Interest` if it exists in the retrieved set of lists.
    $NamedList = $GetLists->getListByName("General Interest");
    if ($NamedList) print "\n`".$NamedList->getName()."` was last updated ".$NamedList->getUpdatedAt()."\n";

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