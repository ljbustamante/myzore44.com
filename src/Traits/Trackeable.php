<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;

trait Trackeable
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="register_user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $registerUser;

    /**
     * @ORM\Column(type="datetime", name="register_datetime", nullable=true)
     */
    private $registerDatetime;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="last_update_user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $lastUpdateUser;

    /**
     * @ORM\Column(type="datetime", name="last_update_datetime", nullable=true)
     */
    private $lastUpdateDatetime;

    /**
     * Set registerDatetime
     *
     * @param \DateTime $registerDatetime
     */
    public function setRegisterDatetime($registerDatetime)
    {
        $this->registerDatetime = $registerDatetime;

        return $this;
    }

    /**
     * Get registerDatetime
     *
     * @return \DateTime
     */
    public function getRegisterDatetime()
    {
        return $this->registerDatetime;
    }

    /**
     * Set lastUpdateDatetime
     *
     * @param \DateTime $lastUpdateDatetime
     */
    public function setLastUpdateDatetime($lastUpdateDatetime)
    {
        $this->lastUpdateDatetime = $lastUpdateDatetime;

        return $this;
    }

    /**
     * Get lastUpdateDatetime
     *
     * @return \DateTime
     */
    public function getLastUpdateDatetime()
    {
        return $this->lastUpdateDatetime;
    }

    /**
     * Set registerUser
     *
     * @param \AppBundle\Entity\User $registerUser
     */
    public function setRegisterUser(\AppBundle\Entity\User $registerUser = null)
    {
        $this->registerUser = $registerUser;

        return $this;
    }

    /**
     * Get registerUser
     *
     * @return \AppBundle\Entity\User
     */
    public function getRegisterUser()
    {
        return $this->registerUser;
    }

    /**
     * Set lastUpdateUser
     *
     * @param \AppBundle\Entity\User $lastUpdateUser
     */
    public function setLastUpdateUser(\AppBundle\Entity\User $lastUpdateUser = null)
    {
        $this->lastUpdateUser = $lastUpdateUser;

        return $this;
    }

    /**
     * Get lastUpdateUser
     *
     * @return \AppBundle\Entity\User
     */
    public function getLastUpdateUser()
    {
        return $this->lastUpdateUser;
    }
}
