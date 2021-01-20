<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserType;


class InscriptionController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function index (Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            
            // ON ACTIVE DIRECTEMENT LE COMPTE
            // $user->setRoles(["ROLE_MEMBER"]);

        }
        return $this->redirectToRoute('app_register');

        // LA METHODE render VIENT DE LA CLASSE PARENTE AbstractController
        // ON VA CHARGER LE CODE DU TEMPLATE : templates/inscription/index.html.twig
        return $this->render('inscription/index.html.twig', [
            // 'controller_name' => 'InscriptionController',
            'form'            => $form->createView(), //ici on rajoute form pour le formulaire d'inscription (CREATE)
        ]);
    }
}
