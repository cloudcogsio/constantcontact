<?php
/**
 * Better management of access token should be implemented. This is just used for convenience.
 *
 * @see credentials.php.dist for instructions on setting the application credentials.
 * @see authorization_code_capture.php to setup the callback webserver.
 *
 * When the callback webserver is running and credentials have been set in credentials.php, run this script:
 *
 * php demo_authorize.php BROWSER
 *
 * BROWSER should be one of [edge, firefox, chrome] depending on the browser installed on your PC
 *
 * Your browser will open and you will be prompted to login and authorize the application.
 * The redirect is likely to stall since the local webserver is listening on http, simply change https to http in the browser URL bar and hit 'Enter'.
 * The access token will be written to file and this script will end.
 *
 * You may now execute the demo services.
 */

chdir(dirname(realpath(__DIR__)));

set_time_limit(0);
ini_set('max_execution_time', 0);

require_once 'vendor/autoload.php';

use Cloudcogs\ConstantContact\Client;
use Cloudcogs\ConstantContact\Config;
use Cloudcogs\ConstantContact\Constants;

// Application Credentials
$credentials = include 'credentials.php';
$client_id = $credentials['client_id'];
$client_secret = $credentials['client_secret'];
$redirect_uri = 'https://localhost'; // Must be HTTPS


// Create Config
$Config = new Config($client_id, $client_secret, $redirect_uri);

// Get Client instance
$Client = Client::getInstance($Config);

// Add additional scopes as needed. Default scope is `contact_data`
// Scopes defined in `Constants::SCOPE_*`
$Client
    ->addScope(Constants::SCOPE_ACCOUNT_READ)
    ->addScope(Constants::SCOPE_CAMPAIGN_DATA);

// Create authorization URL
$authUrl = $Client->getAuthorizationURL();

// If browser was passed to script, open to approve authorization
if(count($argv) > 1){
    $browser = $argv[1];
    $nowait = false;
    switch (strtolower($browser))
    {
        case "edge":
            $exe = "msedge";
            break;
        case "firefox":
            $exe = "firefox";
            break;
        case "chrome":
            $exe = "chrome";
            break;

        default:
            $nowait = true;
            break;
    }

    if(!$nowait)
    {
        exec('start '.$exe.' "'.$authUrl.'"');

        while(true)
        {
            if (file_exists(Constants::AUTHORIZATION_CODE_FILE))
            break;
        }

        $authCode = file_get_contents(Constants::AUTHORIZATION_CODE_FILE);
        if($Client->getAccessToken($authCode))
        {
            unlink(Constants::AUTHORIZATION_CODE_FILE);
            die('Done');
        }
        else
        {
            die('Unable to get access token');
        }
    }
    else
    {
        die("Undefined browser. Please open URL in a browser of choice.\n".$authUrl);
    }
}

// No browser passed, display auth URL. You must open in a browser.
else
{
    die($authUrl);
}