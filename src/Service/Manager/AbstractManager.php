<?php

namespace App\Service\Manager;

use App\Entity\AbstractEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\UsageTrackingTokenStorage;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class AbstractManager
 * @package App\Service\Manager\Property
 */
abstract class AbstractManager
{
    /**
     * @var UsageTrackingTokenStorage
     */
    private $token;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @param UsageTrackingTokenStorage $token
     */
    public function setToken(UsageTrackingTokenStorage $token)
    {
        $this->token = $token->getToken();
        $this->user  = $this->token->getUser();
    }

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param AbstractEntity $instance
     */
    public function remove(AbstractEntity $instance)
    {
        $this->getEntityManager()->remove($instance);
        $this->getEntityManager()->flush();
    }

    /**
     * @param AbstractEntity $instance
     */
    public function persist(AbstractEntity $instance)
    {
        $this->getEntityManager()->persist($instance);
    }

    /**
     * @param AbstractEntity $instance
     */
    public function save(AbstractEntity $instance)
    {
        if (!$this->getEntityManager()->contains($instance)) {
            $this->getEntityManager()->persist($instance);
        }

        $this->getEntityManager()->flush();
    }

    abstract public function getRepository();
}