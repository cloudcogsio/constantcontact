<?php
namespace Cloudcogs\ConstantContact;

use Cloudcogs\ConstantContact\Exception\DuplicateScopeException;
use Cloudcogs\ConstantContact\Exception\JWKNotFound;

class Config
{
    protected $params = [];
    protected $jwk_file = "data/public.jwk";

    protected $remote_keys = "https://identity.constantcontact.com/oauth2/aus1lm3ry9mF7x2Ja0h8/v1/keys";

    public function __construct(
        $client_id,
        $client_secret,
        $redirect_uri = 'https://localhost',
        array $scope = [Constants::SCOPE_CONTACT_DATA, Constants::SCOPE_OFFLINE_ACCESS], 
        $grant_type = 'authorization_code')
    {
        $this->params[Constants::PARAM_CLIENT_ID] = $client_id;
        $this->params[Constants::PARAM_CLIENT_SECRET] = $client_secret;
        $this->params[Constants::PARAM_REDIRECT_URI] = urlencode($redirect_uri);
        $this->params[Constants::PARAM_GRANT_TYPE] = $grant_type;
        $this->params[Constants::PARAM_SCOPE] = $scope;
    }

    public function getAuthCredentials(): string
    {
        return base64_encode($this->getClientId().":".$this->params[Constants::PARAM_CLIENT_SECRET]);
    }

    public function getClientId() : string
    {
        return $this->params[Constants::PARAM_CLIENT_ID];
    }

    public function getRedirectURI() : string
    {
        return $this->params[Constants::PARAM_REDIRECT_URI];
    }

    public function getGrantType() : string
    {
        return $this->params[Constants::PARAM_GRANT_TYPE];
    }

    public function getScope() : array
    {
        return $this->params[Constants::PARAM_SCOPE];
    }

    public function getScopeAsString() : string
    {
        return implode("+", $this->params[Constants::PARAM_SCOPE]);
    }

    /**
     * Add a scope for authorization
     *
     * @param string $scope
     * @return Config
     * @throws DuplicateScopeException
     */
    public function addScope(string $scope) : Config
    {
        if (!in_array($scope, $this->params[Constants::PARAM_SCOPE]))
        {
            $this->params[Constants::PARAM_SCOPE][] = $scope;
            return $this;
        }

        throw new DuplicateScopeException($scope);
    }

    /**
     * @return string
     * @throws JWKNotFound
     */
    public function getJWKs() : string
    {
        if (!file_exists($this->jwk_file))
        {
            file_put_contents($this->jwk_file, file_get_contents($this->remote_keys));

            if (!file_exists($this->jwk_file))
                throw new JWKNotFound();
        }

        return file_get_contents($this->jwk_file);
    }
}