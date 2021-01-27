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
// POUR L'UPLOAD
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(UserRepository $userRepository,MeetingRepository $meetingRepository, Request $request ): Response
    {
        
        return $this->render('profil/index.html.twig', [
            'meetings' => $meetingRepository->findBy(array(), array('id'=>'desc')), // AFFICHAGE PAR ORDRE DECCROISSANT
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
    public function editUser(Request $request, User $user, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // UPLOAD DE PHOTO
                $photoFile = $form->get('photo')->getData();
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
                    $user->setPhoto($newFilename);       // ON ENREGISTRE LE NOM DU FICHIER

                }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil');
        }

        return $this->render('profil/edit.user.html.twig', [
            'user' => $user,
            'formuser' => $form->createView(),
        ]);
    }

}
