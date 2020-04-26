<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="shelf") 
 * @ORM\Entity(repositoryClass="App\Repository\ShelfRepository")
 */
class Shelf
{
    use \App\Traits\Trackeable;
    use \App\Traits\Activable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(length=100)
     */
    private $shelf;

    /**
     * @ORM\Column(length=10)
     */
    private $area;

    /**
     * @ORM\ManyToOne(targetEntity="Depot", inversedBy="shelfs")
     * @ORM\JoinColumn(name="depot_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $depot;

    public function __construct()
    {
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->depot;
    }

    public function getShelf(): ?string
    {
        return $this->shelf;
    }

    public function setShelf(string $shelf): self
    {
        $this->shelf = $shelf;

        return $this;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function setArea(string $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getDepot(): ?Depot
    {
        return $this->depot;
    }

    public function setDepot(?Depot $depot): self
    {
        $this->depot = $depot;

        return $this;
    }
}
