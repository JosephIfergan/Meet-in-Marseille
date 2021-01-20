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

        
        $messageConfirmation = "Rejoins nous !";
        $messageConfirmation2 = "";

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
            $messageConfirmation = "FELICITATION !";
            $messageConfirmation2 = 'Vous pouvez dés maintenant vous connecter et partager vos passions avec la communauté MeetinMarseille !';
            // do anything else you need here, like send an email

            // return $guardHandler->authenticateUserAndHandleSuccess(
            //     $user,
            //     $request,
            //     $authenticator,
            //     'main' // firewall name in security.yaml
            // );

        }

        return $this->render('registration/register.html.twig', [
            'messageConfirmation'   => $messageConfirmation,
            'messageConfirmation2'   => $messageConfirmation2,
            'registrationForm' => $form->createView(),
        ]);
            


    }

}
