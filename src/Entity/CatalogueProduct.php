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
 * @ORM\Table(name="catalogue_product") 
 * @ORM\Entity(repositoryClass="App\Repository\CatalogueProductRepository")
 */
class CatalogueProduct
{
    use \App\Traits\Trackeable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Catalogue", inversedBy="catalogueProducts")
     * @ORM\JoinColumn(name="catalogue_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $catalogue;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="catalogueProducts")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $product;

    /**
     * @ORM\Column(type="decimal", precision=2, nullable=True)
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="CatalogueProductGroupAttributeValue", mappedBy="catalogueProduct", cascade={"persist"})
     **/
    private $catalogueProductGroupAttributeValues;

    public function __construct()
    {
        // parent::__construct();
        $this->catalogueProductGroupAttributeValue = new \Doctrine\Common\Collections\ArrayCollection();
        $this->catalogueProductGroupAttributeValues = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->product->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCatalogue(): ?Catalogue
    {
        return $this->catalogue;
    }

    public function setCatalogue(?Catalogue $catalogue): self
    {
        $this->catalogue = $catalogue;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Collection|CatalogueProductGroupAttributeValue[]
     */
    public function getCatalogueProductGroupAttributeValues(): Collection
    {
        return $this->catalogueProductGroupAttributeValues;
    }

    public function addCatalogueProductGroupAttributeValue(CatalogueProductGroupAttributeValue $catalogueProductGroupAttributeValue): self
    {
        if (!$this->catalogueProductGroupAttributeValues->contains($catalogueProductGroupAttributeValue)) {
            $this->catalogueProductGroupAttributeValues[] = $catalogueProductGroupAttributeValue;
            $catalogueProductGroupAttributeValue->setCatalogueProduct($this);
        }

        return $this;
    }

    public function removeCatalogueProductGroupAttributeValue(CatalogueProductGroupAttributeValue $catalogueProductGroupAttributeValue): self
    {
        if ($this->catalogueProductGroupAttributeValues->contains($catalogueProductGroupAttributeValue)) {
            $this->catalogueProductGroupAttributeValues->removeElement($catalogueProductGroupAttributeValue);
            // set the owning side to null (unless already changed)
            if ($catalogueProductGroupAttributeValue->getCatalogueProduct() === $this) {
                $catalogueProductGroupAttributeValue->setCatalogueProduct(null);
            }
        }

        return $this;
    }
}
