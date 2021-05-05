<?php
namespace Cloudcogs\ConstantContact\Api;

use GuzzleHttp\Client as HTTPClient;
use Cloudcogs\ConstantContact\Client;
use GuzzleHttp\RequestOptions;
use Cloudcogs\ConstantContact\Api\Exception\InvalidAccessToken;
use Cloudcogs\ConstantContact\Api\Exception\ForbiddenRequest;
use Cloudcogs\ConstantContact\Api\Exception\Conflict;
use Cloudcogs\ConstantContact\Api\Exception\InternalError;
use Cloudcogs\ConstantContact\Api\Exception\TemporarilyUnavailable;
use Cloudcogs\ConstantContact\Api\Exception\BadRequest;
use Cloudcogs\ConstantContact\Api\Exception\ResourceNotFound;
use Cloudcogs\ConstantContact\Api\Exception\UnsupportedMediaType;
use Cloudcogs\ConstantContact\Api\Exception\Accepted;

abstract class AbstractAPI
{
    protected $Client;
    protected $HTTPClient;
    protected $HTTPHeaders;
    protected $HTTPResponse;
    protected $HTTPRequestOptions;

    protected $serviceURL;
    protected $service_uri;

    public function __construct(\Cloudcogs\ConstantContact\Client $Client)
    {
        $this->Client = $Client;
        $this->HTTPClient = new HTTPClient();
        $this->serviceURL = Client::BASEURL_API.$this->service_uri;

        $this->HTTPHeaders = [
            'Authorization' => 'Bearer ' . $this->Client->getAccessToken(null),
            'Content-Type'  => 'application/json'
        ];

        $this->HTTPRequestOptions = [
            RequestOptions::HEADERS => $this->HTTPHeaders
        ];
    }

    /**
     *
     * @param string $option
     * @param string|array $value
     *
     * @return \Cloudcogs\ConstantContact\Api\AbstractAPI
     */
    public function setHTTPOption($option, $value) : \Cloudcogs\ConstantContact\Api\AbstractAPI
    {
        $this->HTTPRequestOptions[$option] = $value;
        return $this;
    }

    /**
     *
     * @return \GuzzleHttp\Client
     */
    public function HTTPClientProxy()
    {
        return $this->HTTPClient;
    }

    /**
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function HTTPResponseProxy() : \Psr\Http\Message\ResponseInterface
    {
        return $this->HTTPResponse;
    }

    protected function ThrowException($statusCode)
    {
        switch ($statusCode)
        {
            case 202:
                throw new Accepted();
            case 400:
                throw new BadRequest();
            case 401:
                throw new InvalidAccessToken();
            case 403:
                throw new ForbiddenRequest();
            case 404:
                throw new ResourceNotFound();
            case 409:
                throw new Conflict();
            case 415:
                throw new UnsupportedMediaType();
            case 500:
                throw new InternalError();
            case 503:
                throw new TemporarilyUnavailable();
            default:
                throw new \Exception("Unknown Response Code [$statusCode]");
        }
    }

    protected function get()
    {
        $this->preProcessHTTPClient();

        try {
            $response = $this->HTTPClient->get($this->serviceURL, $this->HTTPRequestOptions);
        } catch (\Exception $e)
        {
            $this->ThrowException($e->getCode());
        }

        $this->HTTPResponse = $response;

        return $this->handleResponse();
    }

    protected function put()
    {
        $this->preProcessHTTPClient();

        try {
            $response = $this->HTTPClient->put($this->serviceURL, $this->HTTPRequestOptions);
        } catch (\Exception $e)
        {
            $this->ThrowException($e->getCode());
        }

        $this->HTTPResponse = $response;

        return $this->handleResponse();
    }

    protected function post()
    {
        $this->preProcessHTTPClient();

        try {
            $response = $this->HTTPClient->post($this->serviceURL, $this->HTTPRequestOptions);
        } catch (\Exception $e)
        {
            $this->ThrowException($e->getCode());
        }

        $this->HTTPResponse = $response;

        return $this->handleResponse();
    }

    protected function delete()
    {
        $this->preProcessHTTPClient();

        try {
            $response = $this->HTTPClient->delete($this->serviceURL, $this->HTTPRequestOptions);
        } catch (\Exception $e)
        {
            $this->ThrowException($e->getCode());
        }

        $this->HTTPResponse = $response;

        return $this->handleResponse();
    }

    protected function preProcessHTTPClient(){}
    abstract protected function handleResponse();
    abstract public function send();

}