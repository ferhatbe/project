<?php
namespace App\Controller;

use App\Entity\Colis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class JibcolisController extends AbstractController
{

    // page d'accueil
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('jibcolis/home.html.twig');
    }

    // page comment ca marche
    /**
     * @Route("/Comment_Ca_Marche", name="jibcolis_commentCaMarche")
     */
    public function Guide()
    {
        return $this->render('jibcolis/commentCaMarche.html.twig');
    }

    // Fonction qui affiche tout les colis existant
    /**
     * @Route("/colis",name="jibcolis_colis")
     */
    public function showColis()
    {
        $repo = $this->getDoctrine()->getRepository(Colis::class);
        $colis = $repo->findAll();

        return  $this->render('colis/colis.html.twig', [
            'controller_name' => 'JibcolisController',
            'colis'=>$colis
        ]);

    }

    // Fonction qui affiche tout les trajets existant
    /**
     * @Route("/voyageur",name="jibcolis_voyageur")
     */
    public function showTrajets()
    {
        $repo = $this->getDoctrine()->getRepository(Colis::class);
        $colis = $repo->findAll();

        return  $this->render('colis/voyageur.html.twig', [
            'controller_name' => 'JibcolisController',
            'colis'=>$colis
        ]);

    }
    // Fonction qui affiche toutes les annonces trajets et colis
    /**
     * @Route("/annonces",name="jibcolis_advertissements")
     */
    public function showAllAdvertisement()
    {
        $repo = $this->getDoctrine()->getRepository(Colis::class);
        $colis = $repo->findAll();

        return  $this->render('colis/allAdvertisment.html.twig', [
            'controller_name' => 'JibcolisController',
            'colis'=>$colis
        ]);

    }


}