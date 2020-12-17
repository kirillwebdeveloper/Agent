<?php

namespace App\Exception;

use App\Entity\User;

/**
 * An exception class to contain User-related exceptions.
 */
class UserException extends AppException
{
    /**
     * @var int
     */
    const NOT_EMPTY_FOR_DELETION = 300;

    /**
     * Create an exception indicating that a user is not empty and therefore
     * cannot be removed.
     *
     * @param User $user The user that is not empty.
     *
     * @throws UserException
     */
    public static function notEmptyForRemoval(User $user): UserException
    {
        return new self(sprintf(
            'The user "%s %s" is not empty and thus cannot be removed.',
            $user->getFirstName(),
            $user->getLastName()
        ), self::NOT_EMPTY_FOR_DELETION);
    }
}
