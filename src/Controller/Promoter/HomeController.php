<?php
namespace App\Controller\Promoter;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="promoter_home_index")
     */
    public function index(Request $request){
        return $this->render('Promoter/Home/index.html.twig');
    }
}