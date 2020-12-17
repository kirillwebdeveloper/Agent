<?php

namespace App\Enum\Property;

/**
 * Interface PropertyStatusEnum
 * @package App\Enum\Property
 */
interface PropertyStatusEnum
{
    public const STATUS_UNKNOWN     = 'unknown';
    public const STATUS_NOT_SELLING = 'not_selling';
    public const STATUS_OPPORTUNITY = 'opportunity';
    public const STATUS_FOR_SALE    = 'for_sale';
}