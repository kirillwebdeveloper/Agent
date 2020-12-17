<?php

namespace App\Service\PropertyActivity;

use App\Entity\Property\Property;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface ActivityInterface
 * @package App\Service\PropertyActivity
 */
interface ActivityInterface
{
    /**
     * @return UserInterface
     */
    public function getUser() : UserInterface;

    /**
     * @return string
     */
    public function getType() : string;

    /**
     * @return string
     */
    public function getTitle() : string;

    /**
     * @return string
     */
    public function getContent() : string;

    /**
     * @return Property
     */
    public function getProperty() : Property;
}