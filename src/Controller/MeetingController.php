<?php

namespace App\Controller;

use App\Repository\MeetingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Meeting;
use App\Entity\User;
use App\Form\MeetingType;
use App\Form\UserType;


/**
 * @Route("/meeting")
 */
class MeetingController extends AbstractController
{
    /**
     * @Route("/", name="meeting_index", methods={"GET"})
     */
    public function index(MeetingRepository $meetingRepository): Response
    {
        return $this->render('meeting/index.html.twig', [
            'meetings' => $meetingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="meeting_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $meeting = new Meeting();
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // POUR DONNE LES INFOS DE L'UTILISATEUR CONNECTE
            $user = $this->getUser();
            // POUR DONNE LES INFOS DE L'UTILISATEUR CONNECTE A LA TABLE MEETING
            $meeting -> setUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($meeting);
            $entityManager->flush();

            return $this->redirectToRoute('meeting_index');
        }

        return $this->render('meeting/new.html.twig', [
            'meeting' => $meeting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="meeting_show", methods={"GET"})
     */
    public function show(Meeting $meeting): Response
    {
        return $this->render('meeting/show.html.twig', [
            'meeting' => $meeting,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="meeting_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Meeting $meeting): Response
    {
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('meeting_index');
        }

        return $this->render('meeting/edit.html.twig', [
            'meeting' => $meeting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="meeting_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Meeting $meeting): Response
    {
        if ($this->isCsrfTokenValid('delete'.$meeting->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($meeting);
            $entityManager->flush();
        }

        return $this->redirectToRoute('meeting_index');
    }
        
    /**
     * @Route("/join/meeting/{id}", name="join_meeting", methods={"GET","POST"})
     */
    public function joinMeeting( Meeting $meeting, Request $request): Response
    {

            // $meeting = new Meeting();
            $form = $this->createForm(MeetingType::class, $meeting);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
            // POUR DONNE LES INFOS DE L'UTILISATEUR CONNECTE
            $user = $this->getUser();

            $meeting->addParticipant($user);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($meeting);
            $entityManager->flush();


            return $this->redirectToRoute('meeting_index');
        }

        return $this->render('meeting/aa.html.twig', [
            'meeting' => $meeting,
            'formi' => $form->createView(),
        ]);
    }
}
