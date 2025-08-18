<?php
// src/Controller/ParticipantRegisterController.php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Participants;
use App\Form\ParticipantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantRegisterController extends AbstractController
{
    #[Route('/participant/register', name: 'app_participant_register')]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response {
        $participant = new participants();
        $form = $this->createForm(participantType::class, $participant, [
            'is_edit' => false, // ✅ Ensure it's in register mode
        ]);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $participant->getUser();
            
            // ✅ Get password directly from the form
            $newPassword = $form->get('user')->get('mot_de_passe')->getData();
    
            if ($newPassword) {
                $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
                $user->setMotdepasse($hashedPassword);
            }
    
            $user->setDateinscription(new \DateTime());
            $user->setFailedattempts(0);
            $user->setBlockeduntil(null);
            $user->setRoles(['ROLE_participant']);
    
            $entityManager->persist($user);
            $entityManager->persist($participant);
            $entityManager->flush();
    
            $this->addFlash('success', 'Inscription réussie!');
    
            return $this->redirectToRoute('app_home');
        }
    
        return $this->render('participant/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


    #[Route('participant/{id_participant}/show', name: 'app_participant_show', methods: ['GET'])]
    public function show(Participants $participant): Response {
        return $this->render('participant/show.html.twig', [
            'participant' => $participant,
        ]);
    }

    #[Route('/participant/list', name: 'app_participant_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response {
        $participants = $entityManager
            ->getRepository(Participants::class)
            ->findAll();

        return $this->render('participant/index.html.twig', [
            'participants' => $participants,
        ]);
    }

    #[Route('/participant/{id_participant}/edit', name: 'app_participant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Participants $participants, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response {
        $form = $this->createForm(ParticipantType::class, $participants, [
            'is_edit' => true, // ✅ Ensure edit mode
        ]);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $participants->getUser();
            
    
    
            $entityManager->flush();
    
            $this->addFlash('success', 'Participant mis à jour avec succès');
            return $this->redirectToRoute('app_participant_index');
        }
    
        return $this->render('/participant/edit.html.twig', [
            'participant' => $participants,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/participant/{id_participant}', name: 'app_participant_delete', methods: ['POST'])]
    public function delete(Request $request, Participants $participant, EntityManagerInterface $entityManager): Response {
        if ($this->isCsrfTokenValid('delete'.$participant->getIdparticipant(), $request->request->get('_token'))) {
            // Supprimer d'abord l'utilisateur associé
            $user = $participant->getUser();
            $entityManager->remove($participant);
            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash('success', 'Participant supprimé avec succès');
        }

        return $this->redirectToRoute('app_participant_index');
    }
}
