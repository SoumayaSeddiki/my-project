<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

class HomeControllers extends AbstractController
{
    /**
     * @Route("/home",name="homepage")
     */
    public function homepage()
    {
        return $this->render('page_home.html.twig');
    }

    /**
     * @Route("/inscription",name="inscription")
     */
    public function inscription()
    {
        return $this->render('inscription.html.twig');
    }
}
