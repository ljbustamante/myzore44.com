<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\ORM\Event\LifecycleEventArgs;

trait Seoable
{
    /**
     * @ORM\OneToOne(targetEntity="Seo", cascade={"persist"})
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="seo_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $seo;

     /**
     * Set seo
     *
     * @param \AppBundle\Entity\Seo $seo
     *
     */
    public function setSeo(\AppBundle\Entity\Seo $seo = null)
    {
        $this->seo = $seo;

        return $this;
    }

    /**
     * Get seo
     *
     * @return \AppBundle\Entity\Seo
     */
    public function getSeo()
    {
        return $this->seo;
    }
}
