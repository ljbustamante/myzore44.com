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
 * @ORM\Table(name="product") 
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    use \App\Traits\Trackeable;
    use \App\Traits\Sluggable;
    use \App\Traits\Viewable;
    use \App\Traits\Publishable;
    use \App\Traits\Activable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="Genre", inversedBy="products")
     * @ORM\JoinColumn(name="genre_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $genre;

    /**
     * @ORM\ManyToOne(targetEntity="ProductType", inversedBy="products")
     * @ORM\JoinColumn(name="producttype_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $productType;

    /**
     * @ORM\Column(type="text")
     */
    private $code;

    /**
     * @ORM\Column(type="text")
     */
    private $longDescription;

    /**
     * @ORM\OneToMany(targetEntity="ProductGroupAttributeValue", mappedBy="product", cascade={"persist"})
     **/
    private $productGroupAttributesValue;

    public function __construct()
    {
        // parent::__construct();
        $this->productGroupAttributesValue = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productColors = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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

    public function getLongDescription(): ?string
    {
        return $this->longDescription;
    }

    public function setLongDescription(string $longDescription): self
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getProductType(): ?ProductType
    {
        return $this->productType;
    }

    public function setProductType(?ProductType $productType): self
    {
        $this->productType = $productType;

        return $this;
    }

    /**
     * @return Collection|ProductGroupAttributeValue[]
     */
    public function getProductGroupAttributesValue(): Collection
    {
        return $this->productGroupAttributesValue;
    }

    public function addProductGroupAttributesValue(ProductGroupAttributeValue $productGroupAttributesValue): self
    {
        if (!$this->productGroupAttributesValue->contains($productGroupAttributesValue)) {
            $this->productGroupAttributesValue[] = $productGroupAttributesValue;
            $productGroupAttributesValue->setProduct($this);
        }

        return $this;
    }

    public function removeProductGroupAttributesValue(ProductGroupAttributeValue $productGroupAttributesValue): self
    {
        if ($this->productGroupAttributesValue->contains($productGroupAttributesValue)) {
            $this->productGroupAttributesValue->removeElement($productGroupAttributesValue);
            // set the owning side to null (unless already changed)
            if ($productGroupAttributesValue->getProduct() === $this) {
                $productGroupAttributesValue->setProduct(null);
            }
        }

        return $this;
    }
}
