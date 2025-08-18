<?php

namespace App\Controller;

use App\Entity\Organisateur;
use App\Entity\Partenaire;
use App\Entity\Participants;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
final class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route(name: 'app_user_index', methods: ['GET'])]
public function index(Request $request): Response
{
    $searchTerm = $request->query->get('search', '');

    // Get only users (not Organisateur, Participants, or Partenaire)
    $users = $this->entityManager->getRepository(User::class)->findAll();

    // If search term is provided, filter users
    if (!empty($searchTerm)) {
        $users = $this->searchUsers($searchTerm, $users);
    }

    return $this->render('user/index.html.twig', [
        'users' => $users,
        'searchTerm' => $searchTerm,
    ]);
}

    


private function searchUsers(string $searchTerm, array $users): array
{
    return array_filter($users, function ($user) use ($searchTerm) {
        return stripos($user->getNom(), $searchTerm) !== false
            || stripos($user->getPrenom(), $searchTerm) !== false
            || stripos($user->getEmail(), $searchTerm) !== false
            || stripos($user->getAdresse(), $searchTerm) !== false
            || stripos($user->getTelephone(), $searchTerm) !== false;
    });
}


    #[Route('/user/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
            'is_edit' => false,
        ]);
                $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
 
    
    

    #[Route('/user/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user, [
            'is_edit' => true, // hide password field
        ]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/user/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
    
    
    
    
}
