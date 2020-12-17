<?php

namespace App\Entity;

use ReflectionObject;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;

/**
 * Abstract entity class containing commonly-used helper methods.
 *
 * @MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class AbstractEntity
{
    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $this->setUpdatedAt(new \DateTime('now'));

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(?\DateTime $createdAt) : self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime|null $updatedAt
     * @return $this
     */
    public function setUpdatedAt(?\DateTime $updatedAt) : self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Validate a property that must be contained within a set of valid values.
     *
     * @param string $exceptionClass
     * @param string $property
     * @param array $valid
     * @param bool $allowEmpty
     * @throws \ReflectionException
     */
    protected function validateMemberOf(string $exceptionClass, string $property, array $valid, bool $allowEmpty = false): void
    {
        $reflectionObject = new ReflectionObject($this);
        $reflectionProperty = $reflectionObject->getProperty($property);
        $reflectionProperty->setAccessible(true);

        if (!in_array($reflectionProperty->getValue($this), $valid) && !($allowEmpty && empty($reflectionProperty->getValue($this)))) {
            throw call_user_func([$exceptionClass, 'invalidArgument'], self::getCaller(), $property, $reflectionProperty->getValue($this), $valid);
        }
    }

    /**
     * Validate non-empty properties.
     *
     * @param string $exceptionClass
     * @param array $properties
     * @throws \ReflectionException
     */
    protected function validateNonEmptyProperties(string $exceptionClass, array $properties): void
    {
        $reflectionObject = new ReflectionObject($this);

        foreach ($properties as $property) {

            $reflectionProperty = $reflectionObject->getProperty($property);
            $reflectionProperty->setAccessible(true);

            if (empty($reflectionProperty->getValue($this))) {
                throw call_user_func([$exceptionClass, 'emptyProperty'], self::getCaller(), $property);
            }
        }
    }
}
