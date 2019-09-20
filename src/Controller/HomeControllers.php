<?php


namespace App\Controller;


use App\Entity\Commande;
use App\Entity\Produit;
use App\Entity\User;
use App\Entity\Utilisateur;
use App\Form\CommandeType;
use App\Form\ImageType;
use App\Form\UserRegisterType;
use App\Form\UserType;
//use App\Form\UtilisateurType;
use App\Repository\CategorieRepository;
use App\Repository\CouleurRepository;
use App\Repository\OccasionRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

class HomeControllers extends AbstractController
{
    /**
     * @Route("/home", name="homepage")
     */
    public function home(OccasionRepository $occasionRepository)
    {
        $occasions = $occasionRepository->findAll();

        return $this->render('page_home.html.twig',
            [
                'occasions' => $occasions,
            ]

        );
    }


//    /**
//     * @Route("/connexion", name="connexion")
//     */
//    public function connexion()
//    {
//        $connexion = "fonctionnement";
//
//        return $this->render('connexion.html.twig',
//            [
//                'connexion'=> $connexion,
//            ]
//        );
//    }

    /**
     * @Route("/concept", name="concept")
     */
    public function concept()
    {
        $concept = 'fonctionnement';

        return $this->render('concept.html.twig',

            [
                'concept'=> $concept,
            ]
        );

    }

    /**
     * @Route("/emprunter", name="emprunter")
     */
    public function emprunter()
    {
        $emprunter = 'fonctionnement';

        return $this->render('emprunt.html.twig',
            [
                'emprunter'=> $emprunter,
            ]

        );
    }


//    /**
//     * @Route("/couleurs", name="ocouleurs")
//     */
//    public function couleurs(CouleurRepository $couleurRepository)
//    {
//        $couleurs = $couleurRepository->findAll();
//
//        return $this->render('produit_couleur.html.twig',
//            [
//                'couleurs' => $couleurs
//            ]);
//    }


//    /**
//    * @Route("/inscription", name="inscription")
//    */
//    public function newUser(EntityManagerInterface $entityManager, Request $request)
//    {
//
//        $user = new User();
//        $formUser = $this->createForm(UserType::class, $user);
//        $formUserView = $formUser->createView();
//
//
//        // Si la méthode est POST
//        // si le formulaire est envoyé
//        if ($request->isMethod('Post')) {
//
//
//            // Le formulaire récupère les infos
//            // de la requête
//            $formUser->handleRequest($request);
//
//            // On enregistre l'entité créée avec persist
//            // et flush
//            $entityManager->persist($user);
//            $entityManager->flush();
//        }
//
//        return $this->render('inscription.html.twig',
//            ['form' => $formUserView]);
//    }

    /**
     * @Route("/produit/{id}", name="produit")
     * Méthode qui retourne un seul article qui a pour id la valeur de la wildcard {id}
     */
    //paramètre (entité et repo-> ttes mes requêtes)
    public function produit(ProduitRepository $produitRepository, $id)
    {
        //résultat
        $produits = $produitRepository->findOneByProduit($id);

        //passe en paramètre
        return $this->render('produits.html.twig', [
        'produits' => $produits
    ]);

    }

    /**
     * @Route("/article/{id}", name="article")
     */
    public function article(ProduitRepository $produitRepository, $id,
                            EntityManagerInterface $entityManager,Request $request)
    {
        //pour récupérer l'utilisateur connecté
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $ajout = new Commande();

        $formAjout = $this->createForm(CommandeType::class, $ajout);
        $formAjoutView   = $formAjout->createView();
        $article = $produitRepository->find($id);

        // Si la méthode est POST
        // si le formulaire est envoyé
        if ($request->isMethod('Post')){

            // Le formulaire récupère les infos
            // de la requête
            $formAjout->handleRequest($request);

            //on remplit le champ "user_id" de la table "commande"
            $ajout->setUser($user);

            //on remplit le champ "produit" de la table "commande"
            $ajout->addProduit($article);

            // On enregistre l'entité créée avec persist
            // et flush
            $entityManager->persist($ajout);
            $entityManager->flush();

        }


        //paramètre  de la méthode render pour la transmettre
        return $this->render('produit.html.twig',
            [
                'article' => $article,
                'form' => $formAjoutView,

            ]);
    }


    /**
     * @Route("/register/after", name="register")
     */
    public function register2(Request $request, EntityManagerInterface $entityManager)
    {
        //récupération des infos de l'utilisateur
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        //création formulaire
        $form = $this->createForm(UserRegisterType::class, $user);

        if($request->isMethod('POST')){
            $form->handleRequest($request);

            if($form->isValid()){
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('inscription.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/insert_produit", name="insert_produit")
     */
    public function newProduit(EntityManagerInterface $entityManager, Request $request)
    {

        $image = new Produit();
        $formImage = $this->createForm(ImageType::class, $image);
        $formImageView = $formImage->createView();

        // Si la méthode est POST
        // si le formulaire est envoyé
        if ($request->isMethod('Post')) {


            // Le formulaire récupère les infos
            // de la requête
            $formImage->handleRequest($request);

            // On enregistre l'entité créée avec persist
            // et flush
            $entityManager->persist($image);
            $entityManager->flush();
        }

        return $this->render('ajout_image.html.twig',
            ['image' => $formImageView]);
    }

//    /**
//     * @Route("/ajout_article", name="ajout_article")
//     */
//    public function ajout(EntityManagerInterface $entityManager, \http\Env\Request $request)
//    {
//
//    }


}
