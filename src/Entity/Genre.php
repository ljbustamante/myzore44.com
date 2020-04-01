<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="genre") 
 * @ORM\Entity(repositoryClass="App\Repository\GenreRepository")
 */
class Genre
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
    private $genre;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="genre")
     **/
    private $products;

    public function __construct()
    {
        // parent::__construct();
        // tu propia lógica
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
