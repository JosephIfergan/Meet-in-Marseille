<?php

namespace App\Controller;

use App\Repository\MeetingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MapController extends AbstractController
{
    /**
     * @Route("/map", name="map")
     */

    public function index(MeetingRepository $meetingRepository): Response
    {
        return $this->render('map/index.html.twig', [
            'meetings' => $meetingRepository->findAll(),
        ]);
    }
}
