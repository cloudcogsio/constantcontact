<?php
namespace Cloudcogs\ConstantContact;

use Cloudcogs\ConstantContact\Exception\InvalidAccessTokenResult;

class AccessTokenResponse
{
    protected $ResultData;

    public function __construct(string $result)
    {
        $this->ResultData = json_decode($result);
        if($this->ResultData == null) throw new InvalidAccessTokenResult();
    }

    public function getAccessToken() : ?string
    {
        return $this->ResultData->access_token;
    }

    public function getRefreshToken() : ?string
    {
        return $this->ResultData->refresh_token;
    }

    public function getTokenType() : ?string
    {
        return $this->ResultData->token_type;
    }

    public function getExpiresIn() : ?int
    {
        return intval($this->ResultData->expires_in);
    }

    public function getScope(): ?string
    {
        return $this->ResultData->scope;
    }

    public function getIdToken() : ?string
    {
        return $this->ResultData->id_token;
    }

    public function isError() : bool
    {
        return property_exists($this->ResultData, "error");
    }

    public function getErrorDescription() : ?string
    {
        return $this->ResultData->error_description;
    }

    public function getError() : ?string
    {
        return $this->ResultData->error;
    }

    public function hasInvalidAuthorizationCode() : bool
    {
        return ($this->isError() && $this->getError() == "invalid_grant" && stripos($this->getErrorDescription(),"authorization") > -1);
    }

    public function hasInvalidRefreshToken() : bool
    {
        return ($this->isError() && $this->getError() == "invalid_grant" && stripos($this->getErrorDescription(),"refresh") > -1);
    }
}