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

    public function getAccessToken() : string
    {
        return $this->ResultData->access_token;
    }

    public function getRefreshToken() : string
    {
        return $this->ResultData->refresh_token;
    }

    public function getTokenType() : string
    {
        return $this->ResultData->token_type;
    }
}