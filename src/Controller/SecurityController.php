<?php
namespace App\Controller;

use App\Entity\Colis;
use App\Entity\User;
use App\Form\ColisType;
use App\Form\UserType;
use App\Repository\ColisRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class SecurityController extends AbstractController
{



    // fonction pour l'inscription
    /**
     * @Route("/inscription", name="security_registration")
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


    /**
     * @Route("/connexion", name="security_connexion")
     */
    public function login(){
        return $this->render('security/seConnecter.html.twig');
    }
    /**
     * @Route("/deconnexion",name="security_logout")
     */
    public function logout(){}

}
