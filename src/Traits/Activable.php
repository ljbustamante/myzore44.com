<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\ORM\Event\LifecycleEventArgs;

trait Activable
{
    /**
     * @ORM\Column(type="boolean", nullable=TRUE)
     */
    private $active;

    /**
     * Set active
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }
}
