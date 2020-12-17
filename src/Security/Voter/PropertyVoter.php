<?php

namespace App\Security\Voter;

use App\Entity\Property\Property;
use App\Entity\User;
use App\Entity\UserType\Agent;
use App\Enum\Voter\Property\PropertyVoterEnum;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class PropertyVoter
 * @package App\Security\Voter
 */
class PropertyVoter extends Voter implements PropertyVoterEnum
{
    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports(string $attribute, $subject)
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE, self::MANAGE, self::CREATE])) {
            return false;
        }
        return true;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        if (!$user->getAgent() instanceof Agent) {
            return false;
        }

        /** @var Property $property */
        $property = $subject;

        switch ($attribute) {
            case self::CREATE:
                return $this->canCreate($user);
            case self::MANAGE:
                return $this->canManage($user);
            case self::VIEW:
                return $this->canView($property, $user);
            case self::EDIT:
                return $this->canEdit($property, $user);
            case self::DELETE:
                return $this->canDelete($property, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * @param User $user
     * @return bool
     */
    private function canCreate(User $user)
    {
        return $user->getAgent() instanceof Agent;
    }

    /**
     * @param User $user
     * @return bool
     */
    private function canManage(User $user)
    {
        return $user->getAgent() instanceof Agent;
    }

    /**
     * @param PropertyVoterInterface $property
     * @param User $user
     * @return bool
     */
    private function canView(PropertyVoterInterface $property, User $user)
    {
        return $user->getAgent() === $property->getAgent();
    }

    /**
     * @param PropertyVoterInterface $property
     * @param User $user
     * @return bool
     */
    private function canEdit(PropertyVoterInterface $property, User $user)
    {
        return $this->canView($property, $user);
    }

    /**
     * @param PropertyVoterInterface $property
     * @param User $user
     * @return bool
     */
    private function canDelete(PropertyVoterInterface $property, User $user)
    {
        return $this->canView($property, $user);
    }
}