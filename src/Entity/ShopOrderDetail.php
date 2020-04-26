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
 * @ORM\Table(name="shoporder_detail") 
 * @ORM\Entity(repositoryClass="App\Repository\ShopOrderDetailRepository")
 */
class ShopOrderDetail
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="ShopOrder", inversedBy="shopOrderDetails")
     * @ORM\JoinColumn(name="provider_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $shopOrder;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="shopOrderDetails")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="SET NULL")
     **/
    private $product;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $productName;

    /**
     * @ORM\ManyToOne(targetEntity="ProductGroupAttributeValue")
     * @ORM\JoinColumn(name="productgroupattributevalue_id", referencedColumnName="id", onDelete="SET NULL")
     **/
    private $productGroupAttributeValue;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $productGroupAttributeValueName;

    /**
     * @ORM\Column(type="decimal", name="quantity", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", name="subtotal", nullable=true)
     */
    private $unitaryPrice;

    /**
     * @ORM\Column(type="decimal", name="igv", nullable=true)
     */
    private $totalPrice;

    public function __construct()
    {
        // parent::__construct();
        $this->catalogueProducts = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->productName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(?string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductGroupAttributeValueName(): ?string
    {
        return $this->productGroupAttributeValueName;
    }

    public function setProductGroupAttributeValueName(?string $productGroupAttributeValueName): self
    {
        $this->productGroupAttributeValueName = $productGroupAttributeValueName;

        return $this;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(?string $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitaryPrice(): ?string
    {
        return $this->unitaryPrice;
    }

    public function setUnitaryPrice(?string $unitaryPrice): self
    {
        $this->unitaryPrice = $unitaryPrice;

        return $this;
    }

    public function getTotalPrice(): ?string
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(?string $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getShopOrder(): ?ShopOrder
    {
        return $this->shopOrder;
    }

    public function setShopOrder(?ShopOrder $shopOrder): self
    {
        $this->shopOrder = $shopOrder;

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

    public function getProductGroupAttributeValue(): ?ProductGroupAttributeValue
    {
        return $this->productGroupAttributeValue;
    }

    public function setProductGroupAttributeValue(?ProductGroupAttributeValue $productGroupAttributeValue): self
    {
        $this->productGroupAttributeValue = $productGroupAttributeValue;

        return $this;
    }
}
