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
// POUR L'UPLOAD
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class MapController extends AbstractController
{
    /**
     * @Route("/map", name="map")
     */

    public function index(MeetingRepository $meetingRepository, Request $request, SluggerInterface $slugger): Response
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

            // UPLOAD DE PHOTO
            // https://symfony.com/doc/current/controller/upload_file.html
            $photoFile = $form->get('photo_meeting')->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photoFile->move(
                        $this->getParameter('photos_directory'),        // NE PAS OUBLIER DE CREER LE DOSSIER
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $meeting->setPhotoMeeting($newFilename);       // ON ENREGISTRE LE NOM DU FICHIER
            }
            

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
