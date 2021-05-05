<?php
require_once 'demo_common.php';

use Cloudcogs\ConstantContact\Api\Contacts\EmailAddress;
use Cloudcogs\ConstantContact\Api\Contacts\ContactResource;
use Cloudcogs\ConstantContact\Api\Contacts\PhoneNumber;
use Cloudcogs\ConstantContact\Api\Contacts\StreetAddress;

/** @var $Client \Cloudcogs\ConstantContact\Client **/

// Create a new contact
try {

    $NewContact = new ContactResource();

    $NewContact
        ->setFirstName("John")
        ->setLastName("Snow")
        ->setJobTitle("Night Watchman")
        ->setCompanyName("Night's Watch")
        ->setCreateSource(ContactResource::SOURCE_CONTACT)
        ->setBirthdayMonth(12)
        ->setBirthdayDay(31)
        ->setAnniversary("2020-01-01");

    // Email Address
    $EmailAddress = new EmailAddress();
    $EmailAddress
    ->setPermissionToSend(EmailAddress::SEND_PERMISSION_PENDING)
    ->setAddress('john.doe@thewall.north.wst');

    // Phone Number
    $PhoneNumber = new PhoneNumber();
    $PhoneNumber->setPhoneNumber("800-123-4567")->setKind($PhoneNumber::KIND_WORK);

    // Street Addresses
    $StreetAddress = new StreetAddress();
    $StreetAddress
        ->setKind(StreetAddress::KIND_WORK)
        ->setStreet("Station #1")
        ->setCity("The Wall")
        ->setState("The North")
        ->setCountry("Westeros")
        ->setPostalCode("W0N1TWS1");

    $NewContact
        ->setEmailAddress($EmailAddress)
        ->addPhoneNumber($PhoneNumber)
        ->addStreetAddress($StreetAddress);

    $ContactsAPI = $Client->Contacts();

    // Post the new contact
    $PostedContact = $ContactsAPI->PostContact($NewContact)->send();

    // Show the posted contact
    print $PostedContact;
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