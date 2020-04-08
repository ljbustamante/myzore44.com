<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\ORM\Event\LifecycleEventArgs;

trait Sluggable
{
    /**
     * @ORM\Column(length=200, nullable=TRUE)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return name
     */
    public function getName()
    {
        return $this->name;
    }
}
