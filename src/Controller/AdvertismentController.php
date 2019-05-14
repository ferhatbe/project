<?php
namespace App\Controller;


use App\Entity\Colis;
use App\Entity\User;
use App\Form\ColisType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class AdvertismentController
 * @package App\Controller
 */
class AdvertismentController extends AbstractController
{

    //Le Constructeur
    /**
     * @var ObjectManager $em
     */
    private $em;
    /**
     * @var Security
     */
    private $securityService;

    public function __construct(Security $securityService,ObjectManager $em)
    {
        $this->securityService = $securityService;
        $this->em = $em;
    }

    // Fonction pour recuperer les colis d'un user
    /**
     * @Route("/mesColis/{id]",name="security_mesColis")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mesColis()
    {
        // get User connected
        /**
         * @var $loUser User
         */
        $loUser  = $this->securityService->getToken()->getUser();
        $laListColis = $this->em->getRepository(Colis::class)->findMyListColis($loUser);

        return  $this->render('user/mesColis.html.twig', [
            'controller_name' => 'SecurityController',
            'colis'=>$laListColis
        ]);
    }

    //Fonction pour recuperer les trajets d'un user
    /**
     * @Route("/mesVoyage",name="security_mesVoyage")
     */
    public function mesTrajets()
    {
        // get User connected
        /**
         * @var $loUser User
         */
        $loUser  = $this->securityService->getToken()->getUser();
        $laListColis = $this->em->getRepository(Colis::class)->findMyListColis($loUser);

        return  $this->render('user/mesVoyage.html.twig', [
            'controller_name' => 'SecurityController',
            'colis'=>$laListColis
        ]);
    }


    // Création d'un D'une annonce
    /**
     * @Route("/Creation_Colis", name="jibcolis_createColis")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAdvertisement(Request $request)
    {
        $colis = new Colis();
        $form = $this->createForm(ColisType::class,$colis);
        // analyse de requete
        $form->handleRequest($request);
        //is tout est bon et les champs sont valide

        $user  = $this->securityService->getToken()->getUser();
        $colis->setUser($user);

        if($form->isSubmitted() && $form->isValid()){

            //persister dans le temps
            $this->em->persist($colis);

            //sauvgrader dans la bdd
            $this->em->flush();

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
     * @param Colis $colis
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showColisContact(Colis $colis)
    {
        return  $this->render('security/colisShowContact.html.twig', [
            'colis'=>$colis
        ]);

    }

    // Consulter un trajet puis contacter l'annonceur
    /**
     * @Route("/Consulter_trajet/{id}",name="jibcolis_showTrajet")
     * @param Colis $colis
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showTrajetContact(Colis $colis)
    {
        return  $this->render('security/trajetShowContact.html.twig', [
            'colis'=>$colis
        ]);

    }

    //Consulter mon annonce puis la modifier ou la supprimer
    /**
     * @Route("/Mon_Colis/{id}",name="user_showColis")
     * @param Colis $colis
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function consulterMonColis(Colis $colis)
    {
        return  $this->render('user/monColisDetail.html.twig', [
            'colis'=>$colis
        ]);
    }

    // editer une annonce colis ou trajet
    /**
     * @Route("/Editer_annonce/{id}",name="editer_annonce")
     * @param Colis $annonce
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAdvertisement(Colis $annonce, Request $request)
    {
        $form = $this->createForm(ColisType::class, $annonce);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $this->em->flush();

            return $this->redirectToRoute('security_mesColis');
        }

        return $this->render('user/edit.html.twig', [
            'annonce' => $annonce,
            'form' =>$form->createView()
        ]);

    }

    //supprimer une annonce

    /**
     * @Route("/supprimer_annonce/{id}",name="supprimer_annonce", methods="DELETE")
     * @param Colis $annonce
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAdvertisement(Colis $annonce, Request $request)
    {
        $submittedToken = $request->request->get('token');

        // token pour securiser la supprission

        if ($this->isCsrfTokenValid('delete', $submittedToken)) {

            //requete de supprission

            $this->em->remove($annonce);
            $this->em->flush();
        }

        return $this->redirectToRoute('home');

    }


}