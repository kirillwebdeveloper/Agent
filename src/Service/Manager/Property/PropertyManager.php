<?php

namespace App\Service\Manager\Property;

use App\Entity\Property\Property;
use App\Service\Manager\AbstractManager;

/**
 * Class PropertyManager
 * @package App\Service\Manager\Property
 */
class PropertyManager extends AbstractManager
{
    /**
     * @return array|object[]
     */
    public function findAll()
    {
        return $this->getRepository()
            ->findAll();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function findAllOfCurrentAgent()
    {
        return $this->getRepository()
            ->findAllOfCurrentAgent(
                $this->getAgent()
            );
    }

    /**
     * @return \App\Repository\Property\PropertyRepository|\Doctrine\Persistence\ObjectRepository
     */
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository(Property::class);
    }

    /**
     * @return \App\Entity\UserType\Agent|null
     * @throws \Exception
     */
    public function getAgent()
    {
        if ($this->getUser()->getAgent() == null) {
            throw new \Exception('No Agent in Current User');
        }
        return $this->getUser()->getAgent();
    }
}