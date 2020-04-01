<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\ORM\Event\LifecycleEventArgs;

trait Viewable
{
    /**
     * @ORM\Column(type="integer", nullable=TRUE)
     */
    private $views;

    /**
     * Set views
     *
     * @param integer $views
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer
     */
    public function getViews()
    {
        return $this->views;
    }
}
