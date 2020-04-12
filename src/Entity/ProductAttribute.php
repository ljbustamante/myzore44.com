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
 * @ORM\Table(name="product_attribute") 
 * @ORM\Entity(repositoryClass="App\Repository\ProductAttributeRepository")
 */
class ProductAttribute
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
     * @ORM\Column(type="text")
     */
    private $productAttribute;

    /**
     * @ORM\OneToMany(targetEntity="ProductAttributeValue", mappedBy="productAttribute", cascade={"persist"})
     **/
    private $productAttributeValues;

    /**
     * @ORM\ManyToMany(targetEntity="ProductType", mappedBy="productAttributes")
     **/
    private $productTypes;


    public function __construct()
    {
        // parent::__construct();
        $this->productAttributeValues = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productTypes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->productAttribute;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductAttribute(): ?string
    {
        return $this->productAttribute;
    }

    public function setProductAttribute(string $productAttribute): self
    {
        $this->productAttribute = $productAttribute;

        return $this;
    }

    /**
     * @return Collection|ProductAttributeValue[]
     */
    public function getProductAttributeValues(): Collection
    {
        return $this->productAttributeValues;
    }

    public function addProductAttributeValue(ProductAttributeValue $productAttributeValue): self
    {
        if (!$this->productAttributeValues->contains($productAttributeValue)) {
            $this->productAttributeValues[] = $productAttributeValue;
            $productAttributeValue->setProductAttribute($this);
        }

        return $this;
    }

    public function removeProductAttributeValue(ProductAttributeValue $productAttributeValue): self
    {
        if ($this->productAttributeValues->contains($productAttributeValue)) {
            $this->productAttributeValues->removeElement($productAttributeValue);
            // set the owning side to null (unless already changed)
            if ($productAttributeValue->getProductAttribute() === $this) {
                $productAttributeValue->setProductAttribute(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductType[]
     */
    public function getProductTypes(): Collection
    {
        return $this->productTypes;
    }

    public function addProductType(ProductType $productType): self
    {
        if (!$this->productTypes->contains($productType)) {
            $this->productTypes[] = $productType;
            $productType->addProductAttribute($this);
        }

        return $this;
    }

    public function removeProductType(ProductType $productType): self
    {
        if ($this->productTypes->contains($productType)) {
            $this->productTypes->removeElement($productType);
            $productType->removeProductAttribute($this);
        }

        return $this;
    }
}
