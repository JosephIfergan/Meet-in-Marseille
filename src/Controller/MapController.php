<?php

namespace App\Controller;

use App\Repository\MeetingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Meeting;
use App\Form\MeetingType;
use App\Form\InscritsType;

class MapController extends AbstractController
{
    /**
     * @Route("/map", name="map")
     */

    public function index(MeetingRepository $meetingRepository, Request $request): Response
    {
        
        $meeting = new Meeting();
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);

        $formInscrits = $this->createForm(InscritsType::class, $meeting);
        $formInscrits->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // POUR DONNE LES INFOS DE L'UTILISATEUR CONNECTE
            $user = $this->getUser();
            // POUR DONNE LES INFOS DE L'UTILISATEUR CONNECTE A LA TABLE MEETING
            $meeting -> setUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($meeting);
            $entityManager->flush();

        }

        if ($formInscrits->isSubmitted() && $formInscrits->isValid()) {
            // POUR DONNE LES INFOS DE L'UTILISATEUR CONNECTE
            $user = $this->getUser();

            $id_meeting = $formInscrits->get('id_meeting')->getData();
            $meeting = $meetingRepository-> find($id_meeting);
            // POUR DONNE LES INFOS DE L'UTILISATEUR CONNECTE A LA TABLE MEETING
            $meeting -> addInscrit($user);

            

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($meeting);
            $entityManager->flush();

        }

        return $this->render('map/index.html.twig', [
            'meetings' => $meetingRepository->findBy(array(), array('id'=>'desc')), // AFFICHAGE PAR ORDRE DECCROISSANT
            'meeting' => $meeting,
            'form' => $form->createView(),
            'formInscrits' => $formInscrits->createView(),
        ]);

    }

}
