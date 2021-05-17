<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adds createdAt and updatedAt timestamps to entities.
 * Entities using this, must have HasLifecycleCallbacks annotation.
 *
 * @ORM\HasLifecycleCallbacks
 */
trait TimestampableTrait {

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * Triggering on create event
     *
     * @ORM\PrePersist
     */
    public function onPrePersist(): void
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Triggering on update event
     *
     * @ORM\PreUpdate
     */
    public function onPreUpdate(): void
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Get createdAt timestamp
     *
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt timestamps
     *
     * @param \DateTimeInterface $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get updatedAt timestamp
     *
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt timestamp
     *
     * @param \DateTimeInterface $updatedAt
     * @return $this
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}


