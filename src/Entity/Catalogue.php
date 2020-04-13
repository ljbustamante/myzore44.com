<?php
namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="catalogue") 
 * @ORM\Entity(repositoryClass="App\Repository\CatalogueRepository")
 */
class Catalogue
{
    use \App\Traits\Trackeable;
    use \App\Traits\Sluggable;
    use \App\Traits\Activable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Campaign", inversedBy="catalogues")
     * @ORM\JoinColumn(name="campaign_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $campaign;

    /**
     * @ORM\Column(type="datetime", name="start_date", nullable=true)
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime", name="end_date", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\OneToMany(targetEntity="CatalogueProduct", mappedBy="catalogue", cascade={"persist"})
     **/
    private $catalogueProducts;

    public function __construct()
    {
        // parent::__construct();
        $this->catalogueProducts = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCampaign(): ?Campaign
    {
        return $this->campaign;
    }

    public function setCampaign(?Campaign $campaign): self
    {
        $this->campaign = $campaign;

        return $this;
    }

    /**
     * @return Collection|CatalogueProduct[]
     */
    public function getCatalogueProducts(): Collection
    {
        return $this->catalogueProducts;
    }

    public function addCatalogueProduct(CatalogueProduct $catalogueProduct): self
    {
        if (!$this->catalogueProducts->contains($catalogueProduct)) {
            $this->catalogueProducts[] = $catalogueProduct;
            $catalogueProduct->setCatalogue($this);
        }

        return $this;
    }

    public function removeCatalogueProduct(CatalogueProduct $catalogueProduct): self
    {
        if ($this->catalogueProducts->contains($catalogueProduct)) {
            $this->catalogueProducts->removeElement($catalogueProduct);
            // set the owning side to null (unless already changed)
            if ($catalogueProduct->getCatalogue() === $this) {
                $catalogueProduct->setCatalogue(null);
            }
        }

        return $this;
    }
}
