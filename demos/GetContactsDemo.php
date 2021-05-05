<?php

require_once 'demo_common.php';

use Cloudcogs\ConstantContact\Api\Contacts\GetContacts;
use Cloudcogs\ConstantContact\Api\Contacts\GetContact;

/** @var $Client \Cloudcogs\ConstantContact\Client **/

// Get contacts
try {

    $GetContacts = $Client->Contacts()->GetContacts(GetContacts::STATUS_ACTIVE);
    $GetContacts->setIncludeCount(true)->setLimit(5)->addIncludeContactSubResources(implode(",",[GetContact::INCLUDE_CUSTOM_FIELDS, GetContact::INCLUDE_LIST_MEMBERSHIPS]));
    $GetContacts->send();

    // Array of \Cloudcogs\ConstantContact\Api\Contacts\ContactResource objects
    $Contacts = $GetContacts->contacts();

    /** @var $Contact \Cloudcogs\ConstantContact\Api\Contacts\ContactResource **/
    foreach ($Contacts as $Contact)
    {
        print "ContactID: `".$Contact->getContactId()."`\nEmail: `".$Contact->getEmailAddress()->getAddress()."`\nEmail Source: `".$Contact->getEmailAddress()->getOptInSource()."`\n\n";
    }

    // Show last contact data as JSON string
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