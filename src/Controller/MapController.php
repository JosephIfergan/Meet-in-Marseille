<?php

namespace App\Controller;

use App\Repository\MeetingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Meeting;
use App\Form\MeetingType;

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

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($meeting);
            $entityManager->flush();

        }

        return $this->render('map/index.html.twig', [
            'meetings' => $meetingRepository->findAll(),
            'meeting' => $meeting,
            'form' => $form->createView(),
        ]);

    }

}
