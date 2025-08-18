<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Entity\Offre;
use App\Entity\Evenements;
use App\Entity\User;
use App\Form\ContratType;
use App\Service\SmsSender;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/contrat', name: 'contrat_front_')]
class ContratController extends AbstractController
{
    // ============================
    // ==== PARTIE FRONTEND ========
    // ============================

    #[Route('/new/{idoffre}', name: 'new')]
    public function newFront(int $idoffre, Request $request, EntityManagerInterface $entityManager): Response
    {
        $contrat = new Contrat();
        $offre = $entityManager->getRepository(Offre::class)->find($idoffre);

        if (!$offre) {
            throw $this->createNotFoundException('Offre non trouvée');
        }

        $contrat->setIdoffre($idoffre);

        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $montantInitial = $contrat->getMontant();
                $tauxReduction = $offre->getTauxReduction();
                $montantFinal = $montantInitial * (1 - ($tauxReduction / 100));
                $contrat->setMontant($montantFinal);

                $entityManager->persist($contrat);
                $entityManager->flush();

                $this->addFlash('success', 'Contrat créé avec succès avec réduction appliquée !');
                return $this->redirectToRoute('contrat_front_index');

            } catch (UniqueConstraintViolationException $e) {
                $this->addFlash('error', 'Erreur : Ce contrat existe déjà pour cette offre.');
                return $this->redirectToRoute('contrat_front_new', ['idoffre' => $idoffre]);
            }
        }

        return $this->render('Contrat/front_new.html.twig', [
            'form' => $form->createView(),
            'offre' => $offre,
        ]);
    }

    #[Route('/', name: 'index')]
    public function indexFront(EntityManagerInterface $entityManager, Request $request): Response
    {
        $search = $request->query->get('search');
        $sort = $request->query->get('sort');

        $qb = $entityManager->getRepository(Contrat::class)->createQueryBuilder('c');

        if ($search) {
            $qb->where('c.conditionsContrat LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        if ($sort === 'montant_asc') {
            $qb->orderBy('c.montant', 'ASC');
        } elseif ($sort === 'montant_desc') {
            $qb->orderBy('c.montant', 'DESC');
        }

        $contrats = $qb->getQuery()->getResult();

        $offres = $entityManager->getRepository(Offre::class)->findAll();
        $offresById = [];
        foreach ($offres as $offre) {
            $offresById[$offre->getIdoffre()] = $offre->getTitre();
        }

        $conn = $entityManager->getConnection();

        // Récupérer les utilisateurs
        $sql = 'SELECT Id_user, nom FROM user';
        $stmt = $conn->prepare($sql);
        $users = $stmt->executeQuery()->fetchAllAssociative();
        $usersById = [];
        foreach ($users as $user) {
            $usersById[$user['Id_user']] = $user['nom'];
        }

        // Récupérer les événements
        $sql = 'SELECT id_evenement, titre FROM evenements';
        $stmt = $conn->prepare($sql);
        $events = $stmt->executeQuery()->fetchAllAssociative();
        $eventsById = [];
        foreach ($events as $event) {
            $eventsById[$event['id_evenement']] = $event['titre'];
        }

        return $this->render('Contrat/front_index.html.twig', [
            'contrats' => $contrats,
            'offres' => $offresById,
            'events' => $eventsById,
            'users' => $usersById,
        ]);
    }



    // ============================
    // ==== PARTIE BACKEND =========
    // ============================

    #[Route('/admin', name: 'back_index')]
    public function indexBack(EntityManagerInterface $entityManager, Request $request): Response
    {
        $search = $request->query->get('search');
        $sort = $request->query->get('sort');

        $qb = $entityManager->getRepository(Contrat::class)->createQueryBuilder('c');

        if ($search) {
            $qb->where('c.conditions_contrat LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }

        if ($sort === 'asc') {
            $qb->orderBy('c.montant', 'ASC');
        } elseif ($sort === 'desc') {
            $qb->orderBy('c.montant', 'DESC');
        }

        $contrats = $qb->getQuery()->getResult();

        $offres = $entityManager->getRepository(Offre::class)->findAll();
        $offresById = [];
        foreach ($offres as $offre) {
            $offresById[$offre->getIdoffre()] = $offre->getTitre();
        }

        $conn = $entityManager->getConnection();

        // Récupérer les utilisateurs
        $sql = 'SELECT Id_user, nom FROM user';
        $stmt = $conn->prepare($sql);
        $users = $stmt->executeQuery()->fetchAllAssociative();
        $usersById = [];
        foreach ($users as $user) {
            $usersById[$user['Id_user']] = $user['nom'];
        }

        // Récupérer les événements
        $sql = 'SELECT id_evenement, titre FROM evenements';
        $stmt = $conn->prepare($sql);
        $events = $stmt->executeQuery()->fetchAllAssociative();
        $eventsById = [];
        foreach ($events as $event) {
            $eventsById[$event['id_evenement']] = $event['titre'];
        }

        return $this->render('Contrat/back_index.html.twig', [
            'contrats' => $contrats,
            'offres' => $offresById,
            'events' => $eventsById,
            'users' => $usersById,
        ]);
    }

    #[Route('/admin/{id}', name: 'back_show', methods: ['GET'])]
    public function showBack(Contrat $contrat): Response
    {
        return $this->render('Contrat/back_show.html.twig', [
            'contrat' => $contrat,
        ]);
    }

    #[Route('/admin/{id}/edit', name: 'back_edit', methods: ['GET', 'POST'])]
    public function editBack(Request $request, Contrat $contrat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Contrat modifié avec succès.');
            return $this->redirectToRoute('contrat_front_back_index');
        }

        return $this->render('Contrat/back_edit.html.twig', [
            'form' => $form->createView(),
            'contrat' => $contrat,
        ]);
    }

    #[Route('/admin/{id}', name: 'back_delete', methods: ['POST'])]
    public function deleteBack(Request $request, Contrat $contrat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $contrat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contrat);
            $entityManager->flush();

            $this->addFlash('success', 'Contrat supprimé avec succès.');
        }

        return $this->redirectToRoute('contrat_front_back_index');
    }





    
        private EntityManagerInterface $entityManager;
    
        public function __construct(EntityManagerInterface $entityManager)
        {
            $this->entityManager = $entityManager;
        }
    
        #[Route('/admin/{id}/pdf', name: 'back_pdf', methods: ['GET'])]
        public function generatePdf(Contrat $contrat, Pdf $pdf): Response
        {
            $signaturePath = 'uploads/signatures/signature_contrat_' . $contrat->getId() . '.png';
            $absoluteSignaturePath = $this->getParameter('kernel.project_dir') . '/public/' . $signaturePath;
            $signatureExists = file_exists($absoluteSignaturePath);
    
            $conn = $this->entityManager->getConnection();
    
            $userSql = 'SELECT nom FROM user WHERE Id_user = :idUser';
            $userStmt = $conn->prepare($userSql);
            $userNom = $userStmt->executeQuery(['idUser' => $contrat->getIdUser()])->fetchOne();
    
            $eventSql = 'SELECT titre FROM evenements WHERE id_evenement = :idEvent';
            $eventStmt = $conn->prepare($eventSql);
            $eventTitre = $eventStmt->executeQuery(['idEvent' => $contrat->getIdEvent()])->fetchOne();
    
            $html = $this->renderView('Contrat/back_pdf.html.twig', [
                'contrat' => $contrat,
                'date' => (new \DateTime())->format('d/m/Y'),
                'signatureExists' => $signatureExists,
                'signaturePath' => $signaturePath,
                'userNom' => $userNom ?: 'Utilisateur supprimé',
                'eventTitre' => $eventTitre ?: 'Événement supprimé',
            ]);
    
            $output = $pdf->getOutputFromHtml($html);
    
            return new Response(
                $output,
                200,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="contrat_' . $contrat->getId() . '.pdf"'
                ]
            );
        }
    
    



    #[Route('/admin/{id}/sign', name: 'back_signature', methods: ['GET'])]
    public function signBack(Contrat $contrat): Response
    {
        return $this->render('Contrat/back_signature.html.twig', [
            'id' => $contrat->getId(),
        ]);
    }

    #[Route('/admin/{id}/upload-signature', name: 'back_signature_upload', methods: ['POST'])]
    public function uploadSignatureBack(Request $request, Contrat $contrat): Response
    {
        $data = $request->request->get('signature');

        if ($data) {
            $data = str_replace('data:image/png;base64,', '', $data);
            $data = base64_decode($data);

            $signatureDir = $this->getParameter('kernel.project_dir') . '/public/uploads/signatures';
            if (!is_dir($signatureDir)) {
                mkdir($signatureDir, 0777, true);
            }

            file_put_contents($signatureDir . '/signature_contrat_' . $contrat->getId() . '.png', $data);

            $this->addFlash('success', 'Signature enregistrée avec succès.');
        }

        return $this->redirectToRoute('contrat_front_back_index');
    }
}
