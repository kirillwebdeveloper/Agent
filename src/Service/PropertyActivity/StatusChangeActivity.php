<?php

namespace App\Service\PropertyActivity;

use App\Entity\Property\Property;
use App\Entity\UserType\Agent;
use App\Enum\Property\PropertyActivityTypeEnum;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class StatusChangeActivity
 * @package App\Service\PropertyActivity
 */
class StatusChangeActivity implements ActivityInterface
{
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var string
     */
    private $context;

    /**
     * @var Property
     */
    private $property;

    /**
     * StatusChangeActivity constructor.
     * @param UserInterface $user
     * @param Property $property
     * @param $context
     */
    public function __construct(UserInterface $user, Property $property, $context)
    {
        $this->user     = $user;
        $this->context  = $context;
        $this->property = $property;
    }

    /**
     * @return UserInterface
     */
    public function getUser() : UserInterface
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getType() : string
    {
        return PropertyActivityTypeEnum::TYPE_STATUS_CHANGES;
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        if ($this->getUser()->getAgent() !== null) {
            /** @var Agent $agent */
            $agent = $this->getUser()->getAgent();
            return $agent->getName() . ' ' . $agent->getSurname();
        }

        return $this->getUser()->getUsername();
    }

    /**
     * @return string
     */
    public function getContent() : string
    {
        return $this->context;
    }

    /**
     * @return Property
     */
    public function getProperty() : Property
    {
        return $this->property;
    }
}