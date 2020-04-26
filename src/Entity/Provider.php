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
 * @ORM\Table(name="provider") 
 * @ORM\Entity(repositoryClass="App\Repository\ProviderRepository")
 */
class Provider
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
     * @ORM\Column(length=200)
     */
    private $provider;

    /**
     * @ORM\Column(length=11, nullable=true)
     */
    private $ruc;

    /**
     * @ORM\Column(length=200, nullable=true)
     */
    private $comercialName;

    /**
     * @ORM\Column(length=200, nullable=true)
     */
    private $socialReason;

    /**
     * @ORM\Column(length=100, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(length=200, nullable=true)
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity="Product", inversedBy="providers", cascade={"persist"})
     * @ORM\JoinTable(name="provider_product",
     *      joinColumns={@ORM\JoinColumn(name="provider_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     **/
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="ShopOrder", mappedBy="provider", cascade={"persist"})
     **/
    private $shopOrders;

    public function __construct()
    {
        // parent::__construct();
        $this->products = new ArrayCollection();
        $this->shopOrders = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->provider;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function setProvider(string $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    public function getRuc(): ?string
    {
        return $this->ruc;
    }

    public function setRuc(string $ruc): self
    {
        $this->ruc = $ruc;

        return $this;
    }

    public function getComercialName(): ?string
    {
        return $this->comercialName;
    }

    public function setComercialName(string $comercialName): self
    {
        $this->comercialName = $comercialName;

        return $this;
    }

    public function getSocialReason(): ?string
    {
        return $this->socialReason;
    }

    public function setSocialReason(string $socialReason): self
    {
        $this->socialReason = $socialReason;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
        }

        return $this;
    }

    /**
     * @return Collection|ShopOrder[]
     */
    public function getShopOrders(): Collection
    {
        return $this->shopOrders;
    }

    public function addShopOrder(ShopOrder $shopOrder): self
    {
        if (!$this->shopOrders->contains($shopOrder)) {
            $this->shopOrders[] = $shopOrder;
            $shopOrder->setProvider($this);
        }

        return $this;
    }

    public function removeShopOrder(ShopOrder $shopOrder): self
    {
        if ($this->shopOrders->contains($shopOrder)) {
            $this->shopOrders->removeElement($shopOrder);
            // set the owning side to null (unless already changed)
            if ($shopOrder->getProvider() === $this) {
                $shopOrder->setProvider(null);
            }
        }

        return $this;
    }
}
