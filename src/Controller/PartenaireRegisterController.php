<?php
// src/Controller/PartenaireRegisterController.php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Partenaire;
use App\Form\PartenaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class PartenaireRegisterController extends AbstractController
{
    #[Route('/partenaire/register', name: 'app_partenaire_register')]
  public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response {
      $partenaire = new Partenaire();
      $form = $this->createForm(PartenaireType::class, $partenaire, [
          'is_edit' => false, // ✅ Ensure it's in register mode
      ]);
  
      $form->handleRequest($request);
  
      if ($form->isSubmitted() && $form->isValid()) {
          $user = $partenaire->getUser();
          
          // ✅ Get password directly from the form
          $newPassword = $form->get('user')->get('mot_de_passe')->getData();
  
          if ($newPassword) {
              $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
              $user->setMotdepasse($hashedPassword);
          }
  
          $user->setDateinscription(new \DateTime());
          $user->setFailedattempts(0);
          $user->setBlockeduntil(null);
          $user->setRoles(['ROLE_PARTENAIRE']);
  
          $entityManager->persist($user);
          $entityManager->persist($partenaire);
          $entityManager->flush();
  
          $this->addFlash('success', 'Inscription réussie!');
  
          return $this->redirectToRoute('app_home');
      }
  
      return $this->render('partenaire/register.html.twig', [
          'registrationForm' => $form->createView(),
      ]);
  }
    

  #[Route('/partenaire/{id_partenaire}/show', name: 'app_partenaire_show', methods: ['GET'])]
  public function show(Partenaire $partenaire): Response
  {
    return $this->render('partenaire/show.html.twig', [
      'partenaire' => $partenaire,
    ]);
  }

  #[Route('/partenaire/list', name: 'app_partenaire_index', methods: ['GET'])]
  public function index(EntityManagerInterface $entityManager): Response
  {
    $partenaires = $entityManager
      ->getRepository(Partenaire::class)
      ->findAll();

    return $this->render('partenaire/index.html.twig', [
      'partenaires' => $partenaires,
    ]);
  }

  #[Route('/partenaire/{id_partenaire}/edit', name: 'app_partenaire_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, Partenaire $partenaire, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response {
    $form = $this->createForm(PartenaireType::class, $partenaire, [
        'is_edit' => true, // ✅ Ensure edit mode
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $user = $partenaire->getUser();
        


        $entityManager->flush();

        $this->addFlash('success', 'Partenaire mis à jour avec succès');
        return $this->redirectToRoute('app_partenaire_index');
    }

    return $this->render('/partenaire/edit.html.twig', [
        'partenaire' => $partenaire,
        'form' => $form->createView(),
    ]);
}

  #[Route('/partenaire/{id_partenaire}', name: 'app_partenaire_delete', methods: ['POST'])]
  public function delete(Request $request, Partenaire $partenaire, EntityManagerInterface $entityManager): Response {
    if ($this->isCsrfTokenValid('delete'.$partenaire->getIdpartenaire(), $request->request->get('_token'))) {
      $user = $partenaire->getUser();
      $entityManager->remove($partenaire);
      $entityManager->remove($user);
      $entityManager->flush();

      $this->addFlash('success', 'Partenaire supprimé avec succès');
    }

    return $this->redirectToRoute('app_partenaire_index');
  }
}
