<?php
namespace App\Controller\Site;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="site_home_index")
     */
    public function index(Request $request, $promoterSlug = null){
        $promoter = $this->loadPromoter($promoterSlug);
        return $this->render('Site/Home/index.html.twig', ['user' => $promoter]);
    }

    /**
     * @Route("/nosotros", name="site_home_aboutus")
     */
    public function aboutUs(Request $request, $promoterSlug = null){
        $promoter = $this->loadPromoter($promoterSlug);
        return $this->render('Site/Home/aboutus.html.twig', ['user' => $promoter]);
    }

    public function loadPromoter($userSlug){
        $user = null;
        if($userSlug !== null){
            $user = $this->getDoctrine()
                         ->getRepository(User::class)
                         ->findOneByUsername($userSlug);
            if($user == null){
                throw $this->createNotFoundException('Usuario no existe');
            }
        }

        return $user;
    }
}