<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="productattribute_value") 
 * @ORM\Entity(repositoryClass="App\Repository\ProductAttributeValueRepository")
 */
class ProductAttributeValue
{
    use \App\Traits\Trackeable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="ProductAttribute", inversedBy="productAttributeValues")
     * @ORM\JoinColumn(name="product_attribute_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $productAttribute;

    /**
     * @ORM\Column(type="text")
     */
    private $productAttributeValue;

    public function __construct()
    {
        // parent::__construct();
    }
}
