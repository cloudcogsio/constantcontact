<?php

require_once 'demo_common.php';

/** @var $Client \Cloudcogs\ConstantContact\Client **/

// Delete a contact
try {
    $contact_id = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";

    $isDeleted = $Client->Contacts()->DeleteContact($contact_id)->send();

    if ($isDeleted) print "ContactID: $contact_id was deleted";

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