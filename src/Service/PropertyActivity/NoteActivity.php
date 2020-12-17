<?php

namespace App\Service\PropertyActivity;

use App\Entity\Property\Note\Note;
use App\Entity\Property\Property;
use App\Entity\UserType\Agent;
use App\Enum\Property\PropertyActivityTypeEnum;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class NoteActivity
 * @package App\Service\PropertyActivity
 */
class NoteActivity implements ActivityInterface
{
    /**
     * @var Note
     */
    private $note;

    /**
     * NoteActivity constructor.
     * @param Note $note
     */
    public function __construct(Note $note)
    {
        $this->note = $note;
    }

    /**
     * @return UserInterface
     */
    public function getUser() : UserInterface
    {
        return $this->note->getUser();
    }

    /**
     * @return string
     */
    public function getType() : string
    {
        return PropertyActivityTypeEnum::TYPE_NOTE;
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        if ($this->note->getUser()->getAgent() !== null) {
            /** @var Agent $agent */
            $agent = $this->note->getUser()->getAgent();
            return $agent->getName() . ' ' . $agent->getSurname();
        }

        return $this->note->getUser()->getUsername();
    }

    /**
     * @return string
     */
    public function getContent() : string
    {
        return $this->note->getContent();
    }

    /**
     * @return Property
     */
    public function getProperty() : Property
    {
        return $this->note->getProperty();
    }
}