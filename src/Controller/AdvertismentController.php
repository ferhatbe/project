<?php
namespace App\Controller;


use App\Entity\Colis;
use App\Form\ColisType;
use App\Repository\ColisRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class AdvertismentController extends AbstractController
{
    /**
     * @Route("/mesColis",name="security_mesColis")
     */
    public function showColis()
    {
        $repo = $this->getDoctrine()->getRepository(Colis::class);
        $coliss = $repo->findAll();

        return  $this->render('user/mesColis.html.twig', [
            'controller_name' => 'SecurityController',
            'coliss'=>$coliss
        ]);

    }
    /**
     * @Route("/mesVoyage",name="security_mesVoyage")
     */
    public function showVoyageur()
    {
        $repo = $this->getDoctrine()->getRepository(Colis::class);
        $coliss = $repo->findAll();

        return  $this->render('user/mesVoyage.html.twig', [
            'controller_name' => 'SecurityController',
            'coliss'=>$coliss
        ]);

    }



    /**
     * @Route("/Creation_Colis", name="jibcolis_createColis")
     */
    public function createColis(Request $request, ObjectManager $manager, Security $securityService)
    {
        $colis = new Colis();
        $form = $this->createForm(ColisType::class,$colis);
        // analyse de requete
        $form->handleRequest($request);
        //is tout est bon et les champs sont valide

        $user  = $securityService->getToken()->getUser();
        $colis->setUser($user);

        if($form->isSubmitted() && $form->isValid()){

            //persister dans le temps
            $manager->persist($colis);

            //sauvgrader dans la bdd
            $manager->flush();

            // regirection to home
            return $this->redirectToRoute('home');
        }

        return $this->render('colis/createColis.html.twig',[
            'form'=>$form->createView()
        ]);

    }



    // Consulter un Colis et contacter l'annonceur
    /**
     * @Route("/Consulter_annonce/{id}",name="jibcolis_showColis")
     */
    public function showColisContact(Colis $colis)
    {

        return  $this->render('security/colisShowContact.html.twig', [
            'colis'=>'$colis'
        ]);

    }


}