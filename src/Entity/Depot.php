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
 * @ORM\Table(name="depot") 
 * @ORM\Entity(repositoryClass="App\Repository\DepotRepository")
 */
class Depot
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
    private $depot;

    /**
     * @ORM\OneToMany(targetEntity="Shelf", mappedBy="depot", cascade={"persist"})
     **/
    private $shelfs;

    public function __construct()
    {
        $this->shelfs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->depot;
    }

    public function getDepot(): ?string
    {
        return $this->depot;
    }

    public function setDepot(string $depot): self
    {
        $this->depot = $depot;

        return $this;
    }

    /**
     * @return Collection|Shelf[]
     */
    public function getShelfs(): Collection
    {
        return $this->shelfs;
    }

    public function addShelf(Shelf $shelf): self
    {
        if (!$this->shelfs->contains($shelf)) {
            $this->shelfs[] = $shelf;
            $shelf->setDepot($this);
        }

        return $this;
    }

    public function removeShelf(Shelf $shelf): self
    {
        if ($this->shelfs->contains($shelf)) {
            $this->shelfs->removeElement($shelf);
            // set the owning side to null (unless already changed)
            if ($shelf->getDepot() === $this) {
                $shelf->setDepot(null);
            }
        }

        return $this;
    }
}
