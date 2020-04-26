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
 * @ORM\Table(name="catalogueproduct_productgroupattributevalue") 
 * @ORM\Entity(repositoryClass="App\Repository\CatalogueProductGroupAttributeValueRepository")
 */
class CatalogueProductGroupAttributeValue
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="CatalogueProduct", inversedBy="catalogueProductGroupAttributeValues")
     * @ORM\JoinColumn(name="catalogueproduct_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $catalogueProduct;

    /**
     * @ORM\ManyToOne(targetEntity="ProductGroupAttributeValue", inversedBy="catalogueProductGroupAttributeValues")
     * @ORM\JoinColumn(name="productgroupattributevalue_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $productGroupAttributeValue;

    /**
     * @ORM\Column(type="decimal", precision=2, nullable=True)
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=True)
     */
    private $physicalStock;

    /**
     * @ORM\Column(type="integer", nullable=True)
     */
    private $allowedStock;

    /**
     * @ORM\OneToMany(targetEntity="ShopOrderDetail", mappedBy="productGroupAttributeValue", cascade={"persist"})
     **/
    private $shopOrderDetails;

    public function __construct()
    {
        $this->shopOrderDetails = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->productGroupAttributeValue;
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

    public function getPhysicalStock(): ?int
    {
        return $this->physicalStock;
    }

    public function setPhysicalStock(?int $physicalStock): self
    {
        $this->physicalStock = $physicalStock;

        return $this;
    }

    public function getAllowedStock(): ?int
    {
        return $this->allowedStock;
    }

    public function setAllowedStock(?int $allowedStock): self
    {
        $this->allowedStock = $allowedStock;

        return $this;
    }

    public function getCatalogueProduct(): ?CatalogueProduct
    {
        return $this->catalogueProduct;
    }

    public function setCatalogueProduct(?CatalogueProduct $catalogueProduct): self
    {
        $this->catalogueProduct = $catalogueProduct;

        return $this;
    }

    public function getProductGroupAttributeValue(): ?ProductGroupAttributeValue
    {
        return $this->productGroupAttributeValue;
    }

    public function setProductGroupAttributeValue(?ProductGroupAttributeValue $productGroupAttributeValue): self
    {
        $this->productGroupAttributeValue = $productGroupAttributeValue;

        return $this;
    }

    /**
     * @return Collection|ShopOrderDetail[]
     */
    public function getShopOrderDetails(): Collection
    {
        return $this->shopOrderDetails;
    }

    public function addShopOrderDetail(ShopOrderDetail $shopOrderDetail): self
    {
        if (!$this->shopOrderDetails->contains($shopOrderDetail)) {
            $this->shopOrderDetails[] = $shopOrderDetail;
            $shopOrderDetail->setProductGroupAttributeValue($this);
        }

        return $this;
    }

    public function removeShopOrderDetail(ShopOrderDetail $shopOrderDetail): self
    {
        if ($this->shopOrderDetails->contains($shopOrderDetail)) {
            $this->shopOrderDetails->removeElement($shopOrderDetail);
            // set the owning side to null (unless already changed)
            if ($shopOrderDetail->getProductGroupAttributeValue() === $this) {
                $shopOrderDetail->setProductGroupAttributeValue(null);
            }
        }

        return $this;
    }
}
