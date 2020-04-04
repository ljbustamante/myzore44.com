<?php
namespace App\Entity;

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
     * @ORM\ManyToMany(targetEntity="ProductAttribute", cascade={"persist"})
     * @ORM\JoinTable(name="producttype_attributes",
     *      joinColumns={@ORM\JoinColumn(name="product_type_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_attribute_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     **/
    private $productAttributes;

    public function __construct()
    {
        // parent::__construct();
        $this->productAttributes = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
