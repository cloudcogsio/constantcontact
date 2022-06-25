<?php
namespace Cloudcogs\ConstantContact;

class Constants
{
    const SCOPE_ACCOUNT_READ = 'account_read';
    const SCOPE_ACCOUNT_UPDATE = 'account_update';
    const SCOPE_CONTACT_DATA = 'contact_data';
    const SCOPE_CAMPAIGN_DATA = 'campaign_data';
    const SCOPE_OFFLINE_ACCESS = 'offline_access';

    const PARAM_CLIENT_ID = 'client_id';
    const PARAM_CLIENT_SECRET = 'client_secret';
    const PARAM_REDIRECT_URI = 'redirect_uri';
    const PARAM_GRANT_TYPE = 'grant_type';
    const PARAM_SCOPE = 'scope';

    const ACCESS_TOKEN_FILE = "data/.access_token";
    const AUTHORIZATION_CODE_FILE = "data/.authorization_code";
}