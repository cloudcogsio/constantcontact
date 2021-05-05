<?php
namespace Cloudcogs\ConstantContact\Api\ContactLists;

use Cloudcogs\ConstantContact\Api\AbstractSchema;

class ContactList extends AbstractSchema
{
    /**
     * Unique ID for the contact list
     *
     * @return string
     */
    public function getListId() : string
    {
        return $this->list_id;
    }

    /**
     * The name given to the contact list
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Text describing the list.
     *
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * Identifies whether or not the account has favorited the contact list.
     *
     * @return bool
     */
    public function isFavorite() : bool
    {
        return (bool) $this->favorite;
    }

    /**
     * System generated date and time that the resource was created, in ISO-8601 format.
     *
     * @return string
     */
    public function getCreatedAt() : string
    {
        return $this->created_at;
    }

    /**
     * Date and time that the list was last updated, in ISO-8601 format. System generated.
     *
     * @return string
     */
    public function getUpdatedAt() : string
    {
        return $this->updated_at;
    }

    /**
     * The number of contacts in the contact list.
     *
     * @return int
     */
    public function getMembershipCount() : int
    {
        return intval($this->membership_count);
    }
}