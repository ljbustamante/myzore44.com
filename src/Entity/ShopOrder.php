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
 * @ORM\Table(name="shop_order") 
 * @ORM\Entity(repositoryClass="App\Repository\ShopOrderRepository")
 */
class ShopOrder
{
    use \App\Traits\Trackeable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(length=20)
     */
    private $code;

    /**
     * @ORM\Column(type="datetime", name="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="datetime", name="delivery_date", nullable=true)
     */
    private $deliveryDate;

    /**
     * @ORM\ManyToOne(targetEntity="Provider", inversedBy="shopOrders")
     * @ORM\JoinColumn(name="provider_id", referencedColumnName="id", onDelete="SET NULL")
     **/
    private $provider;

    /**
     * @ORM\Column(type="decimal", name="num_products", nullable=true)
     */
    private $numProducts;

    /**
     * @ORM\Column(type="decimal", name="subtotal", nullable=true)
     */
    private $subtotal;

    /**
     * @ORM\Column(type="decimal", name="igv", nullable=true)
     */
    private $igv;

    /**
     * @ORM\Column(type="decimal", name="total", nullable=true)
     */
    private $total;

    /**
     * @ORM\OneToMany(targetEntity="ShopOrderDetail", mappedBy="shopOrder", cascade={"persist"})
     **/
    private $shopOrderDetails;

    public function __construct()
    {
        // parent::__construct();
        $this->shopOrderDetails = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->code;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(?\DateTimeInterface $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    public function getNumProducts(): ?string
    {
        return $this->numProducts;
    }

    public function setNumProducts(?string $numProducts): self
    {
        $this->numProducts = $numProducts;

        return $this;
    }

    public function getSubtotal(): ?string
    {
        return $this->subtotal;
    }

    public function setSubtotal(?string $subtotal): self
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    public function getIgv(): ?string
    {
        return $this->igv;
    }

    public function setIgv(?string $igv): self
    {
        $this->igv = $igv;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(?string $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getProvider(): ?Provider
    {
        return $this->provider;
    }

    public function setProvider(?Provider $provider): self
    {
        $this->provider = $provider;

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
            $shopOrderDetail->setShopOrder($this);
        }

        return $this;
    }

    public function removeShopOrderDetail(ShopOrderDetail $shopOrderDetail): self
    {
        if ($this->shopOrderDetails->contains($shopOrderDetail)) {
            $this->shopOrderDetails->removeElement($shopOrderDetail);
            // set the owning side to null (unless already changed)
            if ($shopOrderDetail->getShopOrder() === $this) {
                $shopOrderDetail->setShopOrder(null);
            }
        }

        return $this;
    }
}
