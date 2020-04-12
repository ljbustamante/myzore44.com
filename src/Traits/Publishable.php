<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\ORM\Event\LifecycleEventArgs;

trait Publishable
{
    /**
     * @ORM\Column(type="boolean", nullable=TRUE)
     */
    private $published;

    /**
     * @ORM\Column(type="datetime", nullable=TRUE)
     */
    private $publishedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="publishedBy", referencedColumnName="id", onDelete="SET NULL")
     */
    private $publishedBy;

    /**
     * Set published
     *
     * @param boolean $published
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set publishedAt
     *
     * @param \DateTime $publishedAt
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Get publishedAt
     *
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * Set publishedBy
     *
     * @param \App\Entity\User $publishedBy
     */
    public function setPublishedBy(\App\Entity\User $publishedBy = null)
    {
        $this->publishedBy = $publishedBy;

        return $this;
    }

    /**
     * Get publishedBy
     *
     * @return \App\Entity\User
     */
    public function getPublishedBy()
    {
        return $this->publishedBy;
    }
}
