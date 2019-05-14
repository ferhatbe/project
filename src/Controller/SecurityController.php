<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    // Constructeur de la classe
    /**
     * @var ObjectManager $em
     */
    private $manager;
    /**
     * @var Security
     */
    private $securityService;

    public function __construct(Security $securityService,ObjectManager $manager)
    {
        $this->securityService = $securityService;
        $this->manager  = $manager;
    }


    // fonction pour l'inscription d'un nouveau utilisateur

    /**
     * @Route("/inscription", name="security_registration")
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        // analyse de requete
        $form->handleRequest($request);
        //is tout est bon et les champs sont valide

        if($form->isSubmitted() && $form->isValid()){

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            //persister dans le temps
            $manager->persist($user);

            //sauvgrader dans la bdd
            $manager->flush();

            // regirection to login une fois bien inscrit
            return $this->redirectToRoute('security_connexion');
        }

        return $this->render('security/registration.html.twig',[
            'form'=>$form->createView()
        ]);
    }


    // Fonction qui assur le login "Connextion"
    /**
     * @Route("/connexion", name="security_connexion")
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils){

        $error = $authenticationUtils->getLastAuthenticationError();


        return $this->render('security/seConnecter.html.twig', [
            'error' => $error
        ]);
    }

    // Déconnextion
    /**
     * @Route("/deconnexion",name="security_logout")
     */
    public function logout(){}

}
