<?php

namespace App\Enum\Property;

/**
 * Interface PropertyActivityTypeEnum
 * @package App\Enum\Property
 */
interface PropertyActivityTypeEnum
{
    public const TYPE_NOTE           = 'note';
    public const TYPE_CALL           = 'call';
    public const TYPE_SMS            = 'sms';
    public const TYPE_STATUS_CHANGES = 'status_changes';
}