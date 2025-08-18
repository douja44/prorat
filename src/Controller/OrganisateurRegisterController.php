<?php
// src/Controller/OrganisateurRegisterController.php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Organisateur;
use App\Form\OrganisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrganisateurRegisterController extends AbstractController
{
  #[Route('/organisateur/register', name: 'app_organisateur_register')]
public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response {
    $organisateur = new Organisateur();
    $form = $this->createForm(OrganisateurType::class, $organisateur, [
        'is_edit' => false,
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $user = $organisateur->getUser();
        $newPassword = $form->get('user')->get('mot_de_passe')->getData();

        if ($newPassword) {
            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
            $user->setMotdepasse($hashedPassword);
        }

        $user->setDateinscription(new \DateTime());
        $user->setFailedattempts(0);
        $user->setBlockeduntil(null);
        $user->setRoles(['ROLE_ORGANISATEUR']);

        $entityManager->persist($user);
        $entityManager->persist($organisateur);
        $entityManager->flush();

        $this->addFlash('success', 'Inscription réussie!');
        return $this->redirectToRoute('app_home');
    }

    // If form is not valid, just render it normally — Symfony shows the errors
    return $this->render('organisateur/register.html.twig', [
        'registrationForm' => $form->createView(),
    ]);
}

  
  
    
  #[Route('organisateur/{id_organisateur}/show', name: 'app_organisateur_show', methods: ['GET'])]
  public function show(Organisateur $organisateur): Response
  {
    return $this->render('organisateur/show.html.twig', [
      'organisateur' => $organisateur,
    ]);
  }




  #[Route('/organisateur/list', name: 'app_organisateur_index', methods: ['GET'])]
  public function index(EntityManagerInterface $entityManager): Response
  {
    $organisateurs = $entityManager
      ->getRepository(Organisateur::class)
      ->findAll();

    return $this->render('organisateur/index.html.twig', [
      'organisateurs' => $organisateurs,
    ]);
  }

  #[Route('organisateur/{id_organisateur}/edit', name: 'app_organisateur_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Organisateur $organisateur, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response {
    $form = $this->createForm(OrganisateurType::class, $organisateur, [
        'is_edit' => true, // ✅ Ensure edit mode
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $user = $organisateur->getUser();
        


        $entityManager->flush();

        $this->addFlash('success', 'Organisateur mis à jour avec succès');
        return $this->redirectToRoute('app_organisateur_index');
    }

    return $this->render('organisateur/edit.html.twig', [
        'organisateur' => $organisateur,
        'form' => $form->createView(),
    ]);
}

  


  #[Route('organisateur/{id_organisateur}', name: 'app_organisateur_delete', methods: ['POST'])]
  public function delete(Request $request, Organisateur $organisateur, EntityManagerInterface $entityManager): Response {
    if ($this->isCsrfTokenValid('delete'.$organisateur->getIdorganisateur(), $request->request->get('_token'))) {
      // Supprimer d'abord l'utilisateur associé
      $user = $organisateur->getUser();
      $entityManager->remove($organisateur);
      $entityManager->remove($user);
      $entityManager->flush();

      $this->addFlash('success', 'Organisateur supprimé avec succès');
    }

    return $this->redirectToRoute('app_organisateur_index');
  }


}
