<?php


namespace App\Controller;


use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @var ProduitRepository
     */
    private $produitRepository;

    public function _construct(ProduitRepository $produitRepository)
    {
        $this->editer = $produitRepository;
    }
    public function index()
    {
       $produit = $this->editer->findAll();

           return $this->render('admin.html.twig', compact('produit'));
    }
}