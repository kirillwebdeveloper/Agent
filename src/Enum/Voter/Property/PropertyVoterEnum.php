<?php

namespace App\Enum\Voter\Property;

/**
 * Interface PropertyVoterEnum
 * @package App\Enum\Voter\Property
 */
interface PropertyVoterEnum
{
    public const MANAGE = 'property_manage';
    public const CREATE = 'property_create';
    public const VIEW   = 'property_view';
    public const EDIT   = 'property_edit';
    public const DELETE = 'property_delete';
}