<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Form\User1Type;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Meeting;
use App\Form\MeetingType;
use App\Repository\MeetingRepository;


class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(UserRepository $userRepository, MeetingRepository $meetingRepository, Request $request ): Response
    {
        $user= new User();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        $meeting = new Meeting();
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($meeting);
            $entityManager->flush();

        }

        return $this->render('profil/index.html.twig', [
            'users' => $userRepository->findAll(),
            'user' => $user,
            'form' => $form->createView(),
            'meetings' => $meetingRepository->findAll(),
            'meeting' => $meeting,
            'form' => $form->createView(),
        ]);

    }
    
    /**
     * @Route("/{id}", name="profil_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Meeting $meeting): Response
    {
        if ($this->isCsrfTokenValid('delete'.$meeting->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($meeting);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profil');
    }

}
