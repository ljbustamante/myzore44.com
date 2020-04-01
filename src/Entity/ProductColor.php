<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="product_color") 
 * @ORM\Entity(repositoryClass="App\Repository\ProductColorRepository")
 */
class ProductColor
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productColors")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="Color")
     * @ORM\JoinColumn(name="color_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $color;

    /**
     * @ORM\ManyToMany(targetEntity="Size" cascade={"persist"})
     * @ORM\JoinTable(name="productcolor_sizes",
     *      joinColumns={@ORM\JoinColumn(name="productcolor_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="size_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     **/
    private $sizes;

    public function __construct()
    {
        $this->sizes = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
