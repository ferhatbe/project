<?php
namespace App\Controller;

use App\Entity\Colis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class JibcolisController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('jibcolis/home.html.twig');
    }


    /**
     * @Route("/Comment_Ca_Marche", name="jibcolis_commentCaMarche")
     */
    public function Guide()
    {
        return $this->render('jibcolis/commentCaMarche.html.twig');
    }

    /**
     * @Route("/colis",name="jibcolis_colis")
     */
    public function showColis()
    {
        $repo = $this->getDoctrine()->getRepository(Colis::class);
        $coliss = $repo->findAll();

        return  $this->render('colis/colis.html.twig', [
            'controller_name' => 'JibcolisController',
            'coliss'=>$coliss
        ]);

    }
    /**
     * @Route("/voyageur",name="jibcolis_voyageur")
     */
    public function showVoyageur()
    {
        $repo = $this->getDoctrine()->getRepository(Colis::class);
        $coliss = $repo->findAll();

        return  $this->render('colis/voyageur.html.twig', [
            'controller_name' => 'JibcolisController',
            'coliss'=>$coliss
        ]);

    }


}