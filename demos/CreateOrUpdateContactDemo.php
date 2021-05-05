<?php

require_once 'demo_common.php';

use Cloudcogs\ConstantContact\Api\Contacts\ContactCreateOrUpdateInput;

/** @var $Client \Cloudcogs\ConstantContact\Client **/

// Create or update a contact
try {

    $email = 'emailaddress@domain.com';
    $lastname = 'Doe';
    $list_id = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxx'; // required - At least one list ID or comma separated string of list IDs


    $ContactInput = new ContactCreateOrUpdateInput();
    $ContactInput
        ->setEmailAddress($email)
        ->setLastName($lastname)
        ->addListMemberships($list_id);

    $Response = $Client->Contacts()->CreateOrUpdateContact($ContactInput)->send();

    print $Response;

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