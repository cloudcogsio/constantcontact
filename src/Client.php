<?php

namespace Cloudcogs\ConstantContact;

use Cloudcogs;
use Cloudcogs\ConstantContact\Exception\AccessTokenNotDefined;
use Cloudcogs\ConstantContact\Exception\CurlSetupException;
use Cloudcogs\ConstantContact\Exception\AccessTokenResponseFileNotFound;
use Cloudcogs\ConstantContact\Api\ContactLists;
use Cloudcogs\ConstantContact\Api\Contacts;
use Cloudcogs\ConstantContact\Exception\InvalidAuthorizationCode;
use Cloudcogs\ConstantContact\Exception\InvalidRefreshToken;
use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use stdClass;

class Client
{
    const BASEURL_AUTH = "https://authz.constantcontact.com/oauth2/default/v1/authorize";
    const BASEURL_OAUTH2 = "https://authz.constantcontact.com/oauth2/default/v1/token";
    const BASEURL_API = "https://api.cc.email/v3";

    protected $Config;

    /** @var AccessTokenResponse */
    protected $AccessTokenResponse;
    protected $ContactLists;
    protected $Contacts;

    protected static $Instance;

    public static function getInstance(Config $Config): Client
    {
        if (!self::$Instance)
        {
            self::$Instance = new self($Config);
        }

        return self::$Instance;
    }

    private function __construct(Cloudcogs\ConstantContact\Config $Config)
    {
        $this->Config = $Config;
    }

    /**
     *
     * @return string
     */
    public function getAuthorizationURL() : string
    {
        $state = microtime(true);
        return self::BASEURL_AUTH . "?client_id=" . $this->Config->getClientId(). "&scope=" . $this->Config->getScopeAsString(). "&response_type=code" . "&state=$state&redirect_uri=" . $this->Config->getRedirectURI();
    }

    /**
     *
     * @param string $file
     * @return AccessTokenResponse
     * @throws AccessTokenResponseFileNotFound
     *
     * @throws AccessTokenNotDefined
     */
    public function getAccessTokenResponseFromFile(string $file = Constants::ACCESS_TOKEN_FILE) : AccessTokenResponse
    {
        if (file_exists($file))
        {
            $response = file_get_contents($file);
            $AccessTokenResponse = unserialize($response);

            if(!($AccessTokenResponse instanceof AccessTokenResponse))
            {
                throw new AccessTokenNotDefined();
            }

            $this->AccessTokenResponse = $AccessTokenResponse;

            return $this->AccessTokenResponse;
        }

        throw new AccessTokenResponseFileNotFound($file);
    }

    /**
     *
     * @param string $file
     * @param stdClass|null $decoded_token
     * @return Client
     *
     * @throws AccessTokenNotDefined
     */
    public function writeAccessTokenResponseToFile(string $file = Constants::ACCESS_TOKEN_FILE, stdClass $decoded_token = null) : Client
    {
        if(!($this->AccessTokenResponse instanceof AccessTokenResponse))
        {
            throw new AccessTokenNotDefined();
        }

        $ac = fopen($file, "w");
        if ($ac)
        {
            fwrite($ac, serialize($this->AccessTokenResponse));
            fclose($ac);
        }

        if (!is_null($decoded_token))
        {
            $acd = fopen($file."_decoded", "w");
            if ($acd)
            {
                fwrite($acd, serialize($decoded_token));
                fclose($acd);
            }
        }

        return $this;
    }

    /**
     * @param string|null $authorization_code
     * @return string
     * @throws AccessTokenNotDefined
     * @throws CurlSetupException
     * @throws Exception\InvalidAccessTokenResult
     * @throws Exception\InvalidJwtException
     * @throws Exception\JWKNotFound
     * @throws InvalidAuthorizationCode
     * @throws InvalidRefreshToken
     */
    public function getAccessToken(string $authorization_code = null) : string
    {
        if($this->AccessTokenResponse instanceof AccessTokenResponse) {
            return $this->AccessTokenResponse->getAccessToken();
        }

        $url = self::BASEURL_OAUTH2 . "?code=" . $authorization_code . "&redirect_uri=" . $this->Config->getRedirectURI() . "&grant_type=" . $this->Config->getGrantType() . "&scope=" . $this->Config->getScopeAsString();

        return $this->getOrRefreshAccessToken($url);
    }

    /**
     *
     * @throws AccessTokenNotDefined
     * @return string
     */
    public function getRefreshToken() : string
    {
        if(!($this->AccessTokenResponse instanceof AccessTokenResponse))
        {
            throw new AccessTokenNotDefined();
        }

        return $this->AccessTokenResponse->getRefreshToken();
    }

    /**
     * @return string
     * @throws AccessTokenNotDefined
     * @throws CurlSetupException
     * @throws Exception\InvalidAccessTokenResult
     * @throws Exception\InvalidJwtException
     * @throws Exception\JWKNotFound
     * @throws InvalidAuthorizationCode
     * @throws InvalidRefreshToken
     */
    public function refreshAccessToken() : string
    {
        $url = self::BASEURL_OAUTH2 . "?refresh_token=" . $this->getRefreshToken() . "&grant_type=refresh_token";
        return $this->getOrRefreshAccessToken($url);
    }

    /**
     * @param $url
     * @return string
     * @throws AccessTokenNotDefined
     * @throws CurlSetupException
     * @throws Exception\InvalidAccessTokenResult
     * @throws Exception\InvalidJwtException
     * @throws Exception\JWKNotFound
     * @throws InvalidAuthorizationCode
     * @throws InvalidRefreshToken
     */
    protected function getOrRefreshAccessToken($url) : string
    {
        $ch = curl_init();

        if($ch)
        {
            $authorization = 'Authorization: Basic ' . $this->Config->getAuthCredentials();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization));
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch);
            curl_close($ch);

            $this->AccessTokenResponse = new AccessTokenResponse($result);

            if ($this->AccessTokenResponse->isError())
            {
                $this->throwSpecificException();
            }

            $decoded_token = $this->validateAccessToken($this->AccessTokenResponse);

            $this->writeAccessTokenResponseToFile(Constants::ACCESS_TOKEN_FILE, $decoded_token);

            return $this->AccessTokenResponse->getAccessToken();
        }

        throw new CurlSetupException();
    }

    /**
     * @return void
     * @throws InvalidAuthorizationCode|InvalidRefreshToken
     * @throws \Exception
     */
    public function throwSpecificException()
    {
        if ($this->AccessTokenResponse->hasInvalidAuthorizationCode())
        {
            unlink(Constants::AUTHORIZATION_CODE_FILE);
            throw new InvalidAuthorizationCode();
        }

        if ($this->AccessTokenResponse->hasInvalidRefreshToken())
        {
            unlink(Constants::ACCESS_TOKEN_FILE);
            unlink(Constants::ACCESS_TOKEN_FILE."_decoded");
            throw new InvalidRefreshToken();
        }

        throw new \Exception("[".$this->AccessTokenResponse->getError()."] ".$this->AccessTokenResponse->getErrorDescription());
    }

    /**
     * @param AccessTokenResponse $AccessTokenResponse
     * @return stdClass
     * @throws Exception\InvalidJwtException
     * @throws Exception\JWKNotFound
     */
    protected function validateAccessToken(AccessTokenResponse $AccessTokenResponse): stdClass
    {
        $jwt = $AccessTokenResponse->getAccessToken();
        $jwk = $this->Config->getJWKs();

        $TokenData = JWT::decode($jwt, JWK::parseKeySet(json_decode($jwk, true)));

        if ($TokenData->cid != $this->Config->getClientId()) throw new Cloudcogs\ConstantContact\Exception\InvalidJwtException("Invalid token client identifier");
        if (is_null($TokenData->platform_user_id)) throw new Cloudcogs\ConstantContact\Exception\InvalidJwtException("Token is missing platform_user_id");
        if ($TokenData->aud != self::BASEURL_API) throw new Cloudcogs\ConstantContact\Exception\InvalidJwtException("Invalid token audience claim");

        return $TokenData;
    }

    /**
     * @param string $scope
     * @return $this
     * @throws Exception\DuplicateScopeException
     */
    public function addScope(string $scope) : Client
    {
        $this->Config->addScope($scope);

        return $this;
    }

    /**
     * Proxy to the ContactLists API
     * @return ContactLists
     */
    public function ContactLists() : ContactLists
    {
        if(!$this->ContactLists)
        {
            $this->ContactLists = new ContactLists($this);
        }

        return $this->ContactLists;
    }

    /**
     * Proxy to the Contacts API
     * @return Contacts
     */
    public function Contacts() : Contacts
    {
        if (!$this->Contacts)
        {
            $this->Contacts = new Contacts($this);
        }

        return $this->Contacts;
    }
}