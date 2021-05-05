<?php
namespace Cloudcogs\ConstantContact\Api\Contacts;

use Cloudcogs\ConstantContact\Api\AbstractSchema;
use Cloudcogs\ConstantContact\Api\Contacts\Exception\InvalidSendPermission;

class EmailAddress extends AbstractSchema
{
    const CONFIRM_STATUS_PENDING = 'pending';
    const CONFIRM_STATUS_CONFIRMED = 'confirmed';
    const CONFIRM_STATUS_OFF = 'off';

    const SEND_PERMISSION_IMPLICIT = 'implicit';
    const SEND_PERMISSION_EXPLICIT = 'explicit';
    const SEND_PERMISSION_PENDING = 'pending_confirmation';
    const SEND_PERMISSION_UNSUBSCRIBED = 'unsubscribed';
    const SEND_PERMISSION_TEMP_HOLD = 'temp_hold';
    const SEND_PERMISSION_NOT_SET = 'not_set';

    /**
     * The email address of the contact. The email address must be unique for each contact.
     * Max Length: 80 required
     *
     * @return string
     */
    public function getAddress() : string
    {
        return $this->address;
    }

    /**
     * The contact's email address
     *
     * @param string $address
     * @throws \Exception
     * @return \Cloudcogs\ConstantContact\Api\Contacts\EmailAddress
     */
    public function setAddress(string $address) : \Cloudcogs\ConstantContact\Api\Contacts\EmailAddress
    {
        if (filter_var($address, FILTER_VALIDATE_EMAIL))
        {
            $this->address = $address;
            return $this;
        }

        throw new \Exception("Invalid Email Address");
    }

    /**
     * Identifies the type of permission that the Constant Contact account has to send email to the contact.
     * Types of permission: explicit, implicit, not_set, pending_confirmation, temp_hold, unsubscribed.
     * Enum: [implicit, explicit, pending_confirmation, unsubscribed, temp_hold, not_set]
     *
     * @return string
     */
    public function getPermissionToSend() : string
    {
        return $this->permission_to_send;
    }

    /**
     * Identifies the type of permission that the Constant Contact account has been granted to send email to the contact.
     * Types of permission: explicit, implicit, not_set, pending_confirmation, temp_hold, unsubscribed.
     *
     * @param string $permission
     * @throws InvalidSendPermission
     * @return \Cloudcogs\ConstantContact\Api\Contacts\EmailAddress
     */
    public function setPermissionToSend(string $permission) : \Cloudcogs\ConstantContact\Api\Contacts\EmailAddress
    {
        switch ($permission)
        {
            case self::SEND_PERMISSION_IMPLICIT:
            case self::SEND_PERMISSION_EXPLICIT:
            case self::SEND_PERMISSION_PENDING:
            case self::SEND_PERMISSION_UNSUBSCRIBED:
            case self::SEND_PERMISSION_TEMP_HOLD:
            case self::SEND_PERMISSION_NOT_SET:
                $this->permission_to_send = $permission;
                break;
            default:
                throw new InvalidSendPermission($permission);
        }

        return $this;
    }

    /**
     * Date and time that the email_address was created, in ISO-8601 format. System generated.
     *
     * @return string
     */
    public function getCreatedAt() : string
    {
        return $this->created_at;
    }

    /**
     * Date and time that the email_address was last updated, in ISO-8601 format. System generated.
     *
     * @return string
     */
    public function getUpdatedAt() : string
    {
        return $this->updated_at;
    }

    /**
     * Describes who opted-in the email_address; valid values are Contact or Account.
     * Your integration must accurately identify opt_in_source for compliance reasons; value is set on POST, and is read-only going forward.
     *
     * @return string
     */
    public function getOptInSource() : string
    {
        return $this->opt_in_source;
    }

    /**
     * Date and time that the email_address was opted-in to receive email from the account, in ISO-8601 format. System generated.
     *
     * @return string
     */
    public function getOptInDate() : string
    {
        return $this->opt_in_date;
    }

    /**
     * Describes the source of the unsubscribed/opt-out action: either Account or Contact.
     * If the Contact opted-out, then the account cannot send any campaigns to this contact until the contact opts back in.
     * If the Account, then the account can add the contact back to any lists and send to them.
     * Displayed only if contact has been unsubscribed/opt-out.
     *
     * @return string
     */
    public function getOptOutSource() : string
    {
        return $this->opt_out_source;
    }

    /**
     * Date and time that the contact unsubscribed/opted-out of receiving email from the account, in ISO-8601 format.
     * Displayed only if contact has been unsubscribed/opt-out.
     * System generated.
     *
     * @return string
     */
    public function getOptOutDate() : string
    {
        return $this->opt_out_date;
    }

    /**
     * The reason, as provided by the contact, that they unsubscribed/opted-out of receiving email campaigns.
     * Max Length: 255
     *
     * @return string
     */
    public function getOptOutReason() : string
    {
        return $this->opt_out_reason;
    }

    /**
     * Indicates if the contact confirmed their email address after they subscribed to receive emails.
     * Possible values: pending, confirmed, off.
     * Enum: [pending, confirmed, off]
     *
     * @return string
     */
    public function getConfirmStatus() : string
    {
        return $this->confirm_status;
    }
}