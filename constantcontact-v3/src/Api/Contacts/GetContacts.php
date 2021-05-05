<?php
namespace Cloudcogs\ConstantContact\Api\Contacts;

use Cloudcogs\ConstantContact\Client;
use Cloudcogs\ConstantContact\Api\Contacts\Exception\InvalidContactsStatus;
use GuzzleHttp\RequestOptions;

class GetContacts extends GetContact
{
    protected $status = [];
    protected $email;
    protected $lists = [];
    protected $segment_id;
    protected $tags = [];
    protected $updated_after;
    protected $include_count;
    protected $limit;
    protected $contacts;

    const STATUS_ALL = "all";
    const STATUS_ACTIVE = "active";
    const STATUS_DELETED = "deleted";
    const STATUS_NOT_SET = "not_set";
    const STATUS_PENDING_CONFIRMATION = "pending_confirmation";
    const STATUS_TEMP_HOLD = "temp_hold";
    const STATUS_UNSUBSCRIBED = "unsubscribed";

    /**
     *
     * @param Client $Client
     * @param string $status - Use the status query parameter to search for contacts by status.
     * @param string $email - Use the email query parameter to search for a contact using a specific email address.
     * @param string $lists - Use the lists query parameter to search for contacts that are members of one or more specified lists.
     * @param string $segment_id - Use to get contacts that meet the segment criteria for a single specified segment_id.
     * @param string $tags - Use to get contact details for up to 50 specified tags. Use a comma to separate each tag_id.
     * @param string $updated_after - Use updated_after to search for contacts that have been updated after the date you specify; accepts ISO-8601 formatted dates (Ex. YYYY-MM-DD)
     * @param string $include - Use include to specify which contact sub-resources to include in the response. Use a comma to separate multiple sub-resources. Valid values: custom_fields, list_memberships, taggings, phone_numbers, street_addresses.
     * @param bool $include_count - Set include_count=true to include the total number of contacts (contacts_count) that meet all search criteria in the response body.
     * @param int $limit - Specifies the number of results displayed per page of output in the response, from 1 - 500, default = 50.
     */
    public function __construct(Client $Client, string $status = "all", string $email = null, string $lists = null, string $segment_id = null, string $tags = null, string $updated_after = null, string $include = null, bool $include_count = true, int $limit = 50)
    {
        parent::__construct($Client);

        $this->addStatus($status);
        $this->addList($lists);
        $this->setSegmentId($segment_id);
        $this->addTags($tags);
        $this->setUpdatedAfter($updated_after);
        $this->addIncludeContactSubResources($include);
        $this->setIncludeCount($include_count);
        $this->setLimit($limit);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Cloudcogs\ConstantContact\Api\Contacts\GetContact::preProcessHTTPClient()
     */
    protected function preProcessHTTPClient()
    {
        $queryData = [
            'status' => implode(",", $this->status)
        ];

        if ($this->email) $queryData['email'] = $this->email;
        if ($this->lists) $queryData['lists'] = implode(",", $this->lists);
        if ($this->segment_id) $queryData['segment_id'] = $this->segment_id;
        if ($this->tags) $queryData['tags'] = implode(",", $this->tags);
        if ($this->updated_after) $queryData['updated_after'] = $this->updated_after;
        if ($this->include) $queryData['include'] = implode(",", $this->include);
        if ($this->include_count != null) $queryData['include_count'] = $this->include_count;
        if ($this->limit > 0) $queryData['limit'] = $this->limit;

        $this->setHTTPOption(RequestOptions::QUERY, $queryData);
    }

    protected function handleResponse()
    {
        $body = $this->HTTPResponse->getBody();
        $statusCode = $this->HTTPResponse->getStatusCode();

        if ($statusCode == 200)
        {
            $contacts = json_decode($body);
            if ($contacts->contacts)
            {
                foreach ($contacts->contacts as $i=>$contact)
                {
                    $ContactResource = new ContactResource((array) $contact);
                    $contacts->contacts[$i] = $ContactResource;
                }

                $this->contacts = $contacts->contacts;
            }

            return $this;
        }
        else
        {
            $this->ThrowException($statusCode);
        }
    }

    /**
     * Returns the list of contacts retrieved from the last contacts query
     *
     * @return array
     */
    public function contacts()
    {
        return $this->contacts;
    }

    /**
     * Specifies the number of results displayed per page of output in the response, from 1 - 500, default = 50.
     *
     * @param int $limit
     * @return \Cloudcogs\ConstantContact\Api\Contacts\GetContacts
     */
    public function setLimit(int $limit = null)
    {
        if ($limit == null) $limit = 50;
        if ($limit > 500) $limit = 500;
        $this->limit = $limit;

        return $this;
    }

    /**
     * Set include_count=true to include the total number of contacts (contacts_count) that meet all search criteria in the response body.
     *
     * @param bool $include_count
     * @return \Cloudcogs\ConstantContact\Api\Contacts\GetContacts
     */
    public function setIncludeCount(bool $include_count = null) : \Cloudcogs\ConstantContact\Api\Contacts\GetContacts
    {
        if ($include_count == null) return $this;

        $this->include_count = $include_count;
        return $this;
    }

    /**
     * Use updated_after to search for contacts that have been updated after the date you specify; accepts ISO-8601 formatted dates (Ex. YYYY-MM-DD)
     *
     * @param string $updated_after
     * @return \Cloudcogs\ConstantContact\Api\Contacts\GetContacts
     */
    public function setUpdatedAfter(string $updated_after = null) : \Cloudcogs\ConstantContact\Api\Contacts\GetContacts
    {
        if ($updated_after == null) return $this;

        $this->updated_after = date("Y-m-d", strtotime($updated_after));
        return $this;
    }

    /**
     * Use to get contact details for up to 50 specified tags. Use a comma to separate each tag_id.
     *
     * @param string $tags
     * @return \Cloudcogs\ConstantContact\Api\Contacts\GetContacts
     */
    public function addTags(string $tags = null) : \Cloudcogs\ConstantContact\Api\Contacts\GetContacts
    {
        if ($tags == null) return $this;

        $tags = explode(",", $tags);
        foreach ($tags as $tag)
        {
            if (count($this->tags) <= 50)
            {
                $tag = trim($tag);
                if (!in_array($tag, $this->tags))
                {
                    $this->tags[] = $tag;
                }
            }
        }

        return $this;
    }

    /**
     * Use to get contacts that meet the segment criteria for a single specified segment_id.
     * This query parameter can only be combined with the limit query parameter.
     * When using the segment_id query parameter, the V3 API may return a 202 response code instead of a 200 response.
     * The 202 response code indicates that your request has been accepted, but not fully completed.
     * Retry sending your API request to return the completed results and a 200 response code.
     *
     * @param string $segment_id
     * @return \Cloudcogs\ConstantContact\Api\Contacts\GetContacts
     */
    public function setSegmentId(string $segment_id = null) : \Cloudcogs\ConstantContact\Api\Contacts\GetContacts
    {
        if ($segment_id == null) return $this;

        $this->segment_id = $segment_id;
        return $this;
    }

    /**
     * Use the lists query parameter to search for contacts that are members of one or more specified lists.
     * Use a comma to separate multiple list_id values, up to a maximum of 25.
     *
     * @param string $lists
     * @return \Cloudcogs\ConstantContact\Api\Contacts\GetContacts
     */
    public function addList(string $lists = null) : \Cloudcogs\ConstantContact\Api\Contacts\GetContacts
    {
        if ($lists == null) return $this;

        $lists = explode(",", $lists);
        foreach ($lists as $list_id)
        {
            if (count($this->lists) <= 25)
            {
                $list_id = trim($list_id);
                if (!in_array($list_id, $this->lists))
                {
                    $this->lists[] = $list_id;
                }
            }
        }

        return $this;
    }

    /**
     * Use the email query parameter to search for a contact using a specific email address.
     *
     * @param string $email
     * @throws \Exception
     * @return \Cloudcogs\ConstantContact\Api\Contacts\GetContacts
     */
    public function setEmail(string $email) : \Cloudcogs\ConstantContact\Api\Contacts\GetContacts
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $this->email = $email;
            return $this;
        }

        throw new \Exception("Invalid Email Address");
    }

    /**
     * Use the status query parameter to search for contacts by status.
     * This parameter accepts one or more comma separated values: all, active, deleted, not_set, pending_confirmation, temp_hold, and unsubscribed
     *
     * @param string $status
     * @throws InvalidContactsStatus
     * @return \Cloudcogs\ConstantContact\Api\Contacts\GetContacts
     */
    public function addStatus(string $status = null) : \Cloudcogs\ConstantContact\Api\Contacts\GetContacts
    {
        if ($status == null) return $this;

        $statuses = explode(",", $status);
        foreach ($statuses as $status_string)
        {
            $status_string = trim($status_string);

            switch ($status_string)
            {
                case self::STATUS_ALL:
                case self::STATUS_ACTIVE:
                case self::STATUS_DELETED:
                case self::STATUS_NOT_SET:
                case self::STATUS_PENDING_CONFIRMATION:
                case self::STATUS_TEMP_HOLD:
                case self::STATUS_UNSUBSCRIBED:
                    if (!in_array($status_string, $this->status))
                        $this->status[] = $status_string;
                        break;
                default:
                    throw new InvalidContactsStatus($status_string);
            }
        }

        return $this;
    }
}