<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="product_group_attribute_value") 
 * @ORM\Entity(repositoryClass="App\Repository\Product
 * AttributeRepository")
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
     * @ORM\ManyToMany(targetEntity="ProductAttributeValue" cascade={"persist"})
     * @ORM\JoinTable(name="product_productattributevalue",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_attribute_value_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     **/
    private $productAttributeValues;

    public function __construct()
    {
        // parent::__construct();
        $this->productAttributeValues = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
