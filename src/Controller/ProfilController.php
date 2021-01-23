<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
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
        return $this->render('profil/index.html.twig', [
            'users' => $userRepository->findAll(),
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

    /**
     * @Route("/{id}/edit", name="profil_meeting_edit", methods={"GET","POST"})
     */
    public function editMeeting(Request $request, Meeting $meeting): Response
    {
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil');
        }

        return $this->render('profil/edit.meeting.html.twig', [
            'meeting' => $meeting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/editUser", name="profil_user_edit", methods={"GET","POST"})
     */
    public function editUser(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil');
        }

        return $this->render('profil/edit.user.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

}
