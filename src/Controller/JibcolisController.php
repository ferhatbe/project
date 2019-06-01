<?php
namespace App\Controller;

use App\Entity\Colis;
use App\Entity\Message;
use App\Entity\User;
use App\Form\MessageType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class JibcolisController extends AbstractController
{

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
    // page d'accueil
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('jibcolis/home.html.twig');
    }

    /**
     * @Route("/Objectifs", name="objectifs")
     */
    public function objectifs()
    {
        return $this->render('jibcolis/NosObjectifs.html.twig');
    }
    /**
     * @Route("CGU", name="cgu_jibcolis")
     */
    public function cguJibcolis()
    {
        return $this->render('jibcolis/CGU.html.twig');
    }

    /**
     * @Route("Qui_Sommes_Nous", name="quiSommesNous")
     */
    public function quiSommesNous()
    {
        return $this->render('jibcolis/quisommesnous.html.twig');
    }





    //page de contact

    /**
     * @Route("/replayMessage/{id}", name="contactReplay")
     * @param User $user
     * @param Request $request
     * @param Security $security
     * @param UserRepository $repos
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function contactAnnonceur(User $user, Request $request, Security $security, UserRepository $repos): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class,$message);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user_s = $security->getUser();
            $message->setFromTo($user_s);
            $message->setToUser($user);
            $message->setCreatedAt(new \DateTime());
            //persister dans le temps
            $this->em->persist($message);

            //sauvgrader dans la bdd
            $this->em->flush();

            // regirection to home
            return $this->redirectToRoute('message_mesMessages');
        }

        return  $this->render('user/contact.html.twig', [
            'controller_name' => 'JibcolisController',
            'form' =>$form->createView()
        ]);
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
        /**
         * @var $allAdvertisement User
         */
        $allAdvertisement  = $this->securityService->getToken()->getUser();
        $laListColis = $this->em->getRepository(Colis::class)->findAllAdvertisement($allAdvertisement);

        return  $this->render('colis/colis.html.twig', [
            'controller_name' => 'JibcolisController',
            'colis'=>$laListColis
        ]);
    }

    // Fonction qui affiche tout les trajets existant
    /**
     * @Route("/voyageur",name="jibcolis_voyageur")
     */
    public function showTrajets()
    {
        /**
         * @var $allAdvertisement User
         */
        $allAdvertisement  = $this->securityService->getToken()->getUser();
        $laListColis = $this->em->getRepository(Colis::class)->findAllAdvertisement($allAdvertisement);

        return  $this->render('colis/voyageur.html.twig', [
            'controller_name' => 'JibcolisController',
            'colis'=>$laListColis
        ]);

    }

    // Fonction qui affiche toutes les annonces trajets et colis
    /**
     * @Route("/annonces",name="jibcolis_advertissements")
     */
    public function showAllAdvertisement()
    {

        /**
         * @var $allAdvertisement User
         */
        $allAdvertisement  = $this->securityService->getToken()->getUser();
        $laListColis = $this->em->getRepository(Colis::class)->findAllAdvertisement($allAdvertisement);

        return  $this->render('colis/allAdvertisment.html.twig', [
            'controller_name' => 'JibcolisController',
            'colis'=>$laListColis
        ]);

    }
    /**
     * @Route("/#",name="telecharger")
     */
    public function downloadFileAction(){
        $response = new BinaryFileResponse('docs/DECLARATION-DE-CONFIANCE.pdf');
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT,'DECLARATION-DE-CONFIANCE.pdf');
        return $response;
    }


}