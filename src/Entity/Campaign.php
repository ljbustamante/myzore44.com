<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="campaign") 
 * @ORM\Entity(repositoryClass="App\Repository\CampaignRepository")
 */
class Campaign
{
    use \App\Traits\Trackeable;
    use \App\Traits\Sluggable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", name="start_date", nullable=false)
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime", name="end_date", nullable=false)
     */
    private $endDate;

    /**
     * @ORM\OneToMany(targetEntity="Catalogue", mappedBy="campaign")
     **/
    private $catalogues;

    public function __construct()
    {
        // parent::__construct();
        // tu propia lógica
        $this->catalogues = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
