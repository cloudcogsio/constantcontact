<?php
set_time_limit(0);
ini_set('max_execution_time', 0);

require_once '../vendor/autoload.php';

use Cloudcogs\ConstantContact\Client;
use Cloudcogs\ConstantContact\Config;
use Cloudcogs\ConstantContact\Exception\AccessTokenResponseFileNotFound;

// Application Credentials
$credentials = include 'credentials.php';
$client_id = $credentials['client_id'];
$client_secret = $credentials['client_secret'];

// Create Config and get Client
$Config = new Config($client_id, $client_secret);
$Client = Client::getInstance($Config);

// Check for access token
try {
    $Client->getAccessTokenResponseFromFile();
} catch (AccessTokenResponseFileNotFound $e)
{
    print $e->getMessage()."\nPlease see `demo_authorize.php` for more details and to authorize the application with Constant Contact.";
    exit;
}
