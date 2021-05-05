<?php
/**
 * Use this to capture and write the access token to file.
 * Better management of access token should be implemented. This is just used for convenience.
 *
 * Example Usage:
 * Start the built-in php webserver and redirect traffic to this file
 *
 * php -S 0.0.0.0:80 -t . authorization_code_capture.php
 *
 * @see demo_authorize.php for initiating the OAuth process once this file is running.
 */
if(isset($_GET['code']))
{
    $authCode = $_GET['code'];
    $ac = fopen(".authorization_code", "w");
    if ($ac)
    {
        fwrite($ac, $authCode);
        fclose($ac);
        die("Authorization complete.");
    }
}