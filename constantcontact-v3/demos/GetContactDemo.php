<?php

require_once 'demo_common.php';

use Cloudcogs\ConstantContact\Api\Contacts\GetContact;

/** @var $Client \Cloudcogs\ConstantContact\Client **/

// Get contact
try {
    $contact_id = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";

    $GetContact = $Client->Contacts()->GetContact($contact_id, implode(",",[GetContact::INCLUDE_CUSTOM_FIELDS, GetContact::INCLUDE_LIST_MEMBERSHIPS]));
    $Contact = $GetContact->send();

    // Show contact data as JSON string
    print $Contact;
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