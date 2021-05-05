<?php
require_once 'demo_common.php';

use Cloudcogs\ConstantContact\Api\Contacts\ContactResource;
use Cloudcogs\ConstantContact\Api\Contacts\StreetAddress;
use Cloudcogs\ConstantContact\Api\Contacts\GetContact;
use Cloudcogs\ConstantContact\Api\Contacts\EmailAddress;

/** @var $Client \Cloudcogs\ConstantContact\Client **/

// Update a contact
try {

    // First, retrieve the contact (All existing data must be sent in the update or it will be overwritten with nulls - Constant Contact API limitation)
    $contact_id = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";

    $GetContact = $Client->Contacts()->GetContact($contact_id,implode(",",[GetContact::INCLUDE_STREET_ADDRESSES, GetContact::INCLUDE_PHONE_NUMBERS]));

    /** @var $ExistingContact \Cloudcogs\ConstantContact\Api\Contacts\ContactResource **/
    $ExistingContact = $GetContact->send();

    // Update the contact
    $ExistingContact->setJobTitle("Crowned on ".date("Y-m-d"));
    $ExistingContact->setUpdateSource(ContactResource::SOURCE_CONTACT);
    $ExistingContact->getEmailAddress()->setPermissionToSend(EmailAddress::SEND_PERMISSION_PENDING);

    $addresses = $ExistingContact->getStreetAddresses();

    /** @var $StreetAddress \Cloudcogs\ConstantContact\Api\Contacts\StreetAddress **/
    foreach ($addresses as &$StreetAddress)
    {
        // Update the street field of the Work address
        if ($StreetAddress->getKind() == StreetAddress::KIND_WORK)
        {
            $StreetAddress->setStreet("Station ".date("His"));
        }
    }

    // Update the contact
    $UpdatedContact = $Client->Contacts()->PutContact($ExistingContact, $contact_id)->send();

    // Show updated contact
    print $UpdatedContact;
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