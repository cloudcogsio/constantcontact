<?php
namespace Cloudcogs\ConstantContact\Api\Contacts;

use Cloudcogs\ConstantContact\Api\AbstractSchema;

class ContactCreateOrUpdateResponse extends AbstractSchema
{
    const ACTION_CREATED = 'created';
    const ACTION_UPDATED = 'updated';

    /**
     * The unique identifier for the contact that the V3 API created or updated.
     *
     * @return string
     */
    public function getContactId() : string
    {
        return $this->contact_id;
    }

    /**
     * Identifies if the V3 API created a new contact or updated an existing contact.
     * Enum: [created, updated]
     *
     * @return string
     */
    public function getAction() : string
    {
        return $this->action;
    }
}