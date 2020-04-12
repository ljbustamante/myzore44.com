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
 * @ORM\Table(name="product_type") 
 * @ORM\Entity(repositoryClass="App\Repository\ProductTypeRepository")
 */
class ProductType
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
    private $productType;

    /**
     * @ORM\ManyToMany(targetEntity="ProductAttribute", inversedBy="productTypes", cascade={"persist"})
     * @ORM\JoinTable(name="producttype_attributes",
     *      joinColumns={@ORM\JoinColumn(name="product_type_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_attribute_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     **/
    private $productAttributes;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="productType", cascade={"persist"})
     **/
    private $products;

    public function __construct()
    {
        // parent::__construct();
        $this->productAttributes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->productType;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductType(): ?string
    {
        return $this->productType;
    }

    public function setProductType(string $productType): self
    {
        $this->productType = $productType;

        return $this;
    }

    /**
     * @return Collection|ProductAttribute[]
     */
    public function getProductAttributes(): Collection
    {
        return $this->productAttributes;
    }

    public function addProductAttribute(ProductAttribute $productAttribute): self
    {
        if (!$this->productAttributes->contains($productAttribute)) {
            $this->productAttributes[] = $productAttribute;
        }

        return $this;
    }

    public function removeProductAttribute(ProductAttribute $productAttribute): self
    {
        if ($this->productAttributes->contains($productAttribute)) {
            $this->productAttributes->removeElement($productAttribute);
        }

        return $this;
    }
}
