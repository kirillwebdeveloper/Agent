<?php

namespace App\Listener\Audit;

use App\Entity\Property\Property;
use App\Service\Manager\Property\PropertyActivityManager;
use App\Service\PropertyActivity\StatusChangeActivity;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * Class PropertyEntityAuditListener
 * @package App\Listener\Audit
 */
class PropertyEntityAuditListener
{
    /**
     * @var array
     */
    private $fields = ['status'];

    /**
     * @var PropertyActivityManager
     */
    private $propertyActivityManager;

    /**
     * @var StatusChangeActivity|null
     */
    private $audit = null;

    /**
     * PropertyEntityAuditListener constructor.
     * @param PropertyActivityManager $propertyActivityManager
     */
    public function __construct(PropertyActivityManager $propertyActivityManager)
    {
        $this->propertyActivityManager = $propertyActivityManager;
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Property) {
            foreach ($this->fields as $field) {
                if ($args->hasChangedField($field)) {
                    $this->propertyActivityManager->saveActivity(
                        new StatusChangeActivity(
                            $this->propertyActivityManager->getUser(),
                            $entity,
                            'Status changed FROM: ' . $args->getOldValue($field) . ' TO: ' . $args->getNewValue($field)
                        )
                    );
                }
            }
        }
    }
}