<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        // ON CREE UN OBJET POUR STOCKER LES INFOS DU FORMULAIRE
        $user = new User();
        // ON CREE LE FORMULAIRE
        $form = $this->createForm(RegistrationFormType::class, $user);
        // ON RECUPERE LES INFOS ENVOYEES PAR LE FORMULAIRE
        $form->handleRequest($request);

        // MESSAGE DE CONFIRMATION
        $messageConfirmation = "Rejoins nous !";
        $messageConfirmation2 = "";
        $messageConfirmation3 = "";


        if ($form->isSubmitted() && $form->isValid()) {

            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            // ON ACTIVE DIRECTEMENT LE COMPTE
           $user->setRoles(["ROLE_MEMBER"]);
            
           // SI LES INFOS SONT VALIDES                
            // STOCKE DANS LA BDD
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $messageConfirmation = "félicitations !";
            $messageConfirmation2 = "Vous faites désormais partie de la communauté MeetInMarseille,";
            $messageConfirmation3 = "Connectez vous !";

        }

        return $this->render('registration/register.html.twig', [
            // MESSAGE DE CONFIRMATION
            'messageConfirmation'   => $messageConfirmation,
            'messageConfirmation2'  => $messageConfirmation2,
            'messageConfirmation3'  => $messageConfirmation3,
            'registrationForm' => $form->createView(),
        ]);
            


    }

}
