<?php
namespace Cloudcogs\ConstantContact\Api\ContactLists;

use Cloudcogs\ConstantContact\Api\AbstractSchema;

class ListInput extends AbstractSchema
{
    /**
     * The name given to the contact list
     *
     * @param string $name
     * @return \Cloudcogs\ConstantContact\Api\ContactLists\ListInput
     */
    public function setName(string $name) : \Cloudcogs\ConstantContact\Api\ContactLists\ListInput
    {
        $this->name = $name;

        return $this;
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
     * @param string $description
     * @return \Cloudcogs\ConstantContact\Api\ContactLists\ListInput
     */
    public function setDescription(string $description) : \Cloudcogs\ConstantContact\Api\ContactLists\ListInput
    {
        $this->description = $description;

        return $this;
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
     * @param bool $favorite
     * @return \Cloudcogs\ConstantContact\Api\ContactLists\ListInput
     */
    public function setFavorite(bool $favorite) :  \Cloudcogs\ConstantContact\Api\ContactLists\ListInput
    {
        $this->favorite = $favorite;

        return $this;
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
}