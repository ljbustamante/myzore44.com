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
 * @ORM\Table(name="product_group_attribute_value") 
 * @ORM\Entity(repositoryClass="App\Repository\ProductAttributeRepository")
 */
class ProductGroupAttributeValue
{
    use \App\Traits\Trackeable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productGroupAttributesValue")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $product;

    /**
     * @ORM\ManyToMany(targetEntity="ProductAttributeValue", cascade={"persist"})
     * @ORM\JoinTable(name="productgroup_productattributevalue",
     *      joinColumns={@ORM\JoinColumn(name="productgroup_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_attribute_value_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     **/
    private $productAttributeValues;

    public function __construct()
    {
        // parent::__construct();
        $this->productAttributeValues = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->product;
    }

    public function getId(): ?int
    {
        return $this->id;
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
        }

        return $this;
    }

    public function removeProductAttributeValue(ProductAttributeValue $productAttributeValue): self
    {
        if ($this->productAttributeValues->contains($productAttributeValue)) {
            $this->productAttributeValues->removeElement($productAttributeValue);
        }

        return $this;
    }
}
