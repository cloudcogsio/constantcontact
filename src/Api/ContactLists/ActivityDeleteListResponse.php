<?php
namespace Cloudcogs\ConstantContact\Api\ContactLists;

use Cloudcogs\ConstantContact\Api\AbstractSchema;

class ActivityDeleteListResponse extends AbstractSchema
{
    /**
     * Unique ID for the delete list batch job
     *
     * @return string
     */
    public function getActivityId() : string
    {
        return $this->activity_id;
    }

    /**
     * The state of the delete list request:
     *
     * processing - request is being processed
     * completed - job completed
     * cancelled - request was cancelled
     * failed - job failed to complete
     * timed_out - the request timed out before completing
     *
     * Enum: [processing, completed, cancelled, failed, timed_out]
     *
     * @return string
     */
    public function getState() : string
    {
        return $this->state;
    }

    /**
     * Date and time that the request was received, in ISO-8601 format.
     *
     * @return string
     */
    public function getCreatedAt() : string
    {
        return $this->created_at;
    }

    /**
     * Date and time that the request status was updated, in ISO-8601 format.
     *
     * @return string
     */
    public function getUpdatedAt() : string
    {
        return $this->updated_at;
    }

    /**
     * Job completion percentage
     *
     * @return int
     */
    public function getPercentDone() : int
    {
        return $this->percent_done;
    }

    /**
     * Array of messages describing the errors that occurred.
     *
     * @return array
     */
    public function getActivityErrors() : array
    {
        return $this->activity_errors;
    }
}

