<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\OffreType;
use App\Service\SmsSender;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/offre', name: 'offre_front_')]
class OffreController extends AbstractController
{
    // ============================
    // ==== PARTIE FRONTEND ========
    // ============================

    #[Route('/', name: 'index')]
    public function indexFront(EntityManagerInterface $entityManager, Request $request): Response
    {
        $search = $request->query->get('search');
        $sort = $request->query->get('sort');

        $queryBuilder = $entityManager->createQueryBuilder()
            ->select('o')
            ->from(Offre::class, 'o')
            ->leftJoin('App\Entity\Contrat', 'c', 'WITH', 'c.idoffre = o.idoffre')
            ->where('c.id IS NULL');

        if ($search) {
            $queryBuilder->andWhere('o.titre LIKE :search')
                        ->setParameter('search', '%' . $search . '%');
        }

        if ($sort === 'asc') {
            $queryBuilder->orderBy('o.tauxReduction', 'ASC');
        } elseif ($sort === 'desc') {
            $queryBuilder->orderBy('o.tauxReduction', 'DESC');
        }

        $offres = $queryBuilder->getQuery()->getResult();

        return $this->render('Offre/front_index.html.twig', [
            'offres' => $offres,
        ]);
    }
    #[Route('/show/{id}', name: 'show')]
    public function showFront(int $id, EntityManagerInterface $entityManager): Response
    {
        $offre = $entityManager->getRepository(Offre::class)->find($id);

        if (!$offre) {
            throw $this->createNotFoundException('Offre non trouvée.');
        }

        return $this->render('Offre/front_show.html.twig', [
            'offre' => $offre,
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

        $qb = $entityManager->getRepository(Offre::class)->createQueryBuilder('o');

        if ($search) {
            $qb->where('o.titre LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }

        if ($sort === 'asc') {
            $qb->orderBy('o.tauxReduction', 'ASC');
        } elseif ($sort === 'desc') {
            $qb->orderBy('o.tauxReduction', 'DESC');
        }

        $offres = $qb->getQuery()->getResult();

        $tauxReductions = [];
        foreach ($offres as $offre) {
            $taux = $offre->getTauxReduction();
            if (!isset($tauxReductions[$taux])) {
                $tauxReductions[$taux] = 0;
            }
            $tauxReductions[$taux]++;
        }

        $reductionLabels = array_keys($tauxReductions);
        $reductionData = array_values($tauxReductions);

        return $this->render('Offre/back_index.html.twig', [
            'offres' => $offres,
            'reductionLabels' => $reductionLabels,
            'reductionData' => $reductionData,
        ]);
    }

    #[Route('/admin/new', name: 'back_new')]
    public function newBack(Request $request, EntityManagerInterface $entityManager): Response
    {
        $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($offre);
            $entityManager->flush();

            $this->addFlash('success', 'Offre ajoutée avec succès.');
            return $this->redirectToRoute('offre_front_back_index');
        }

        return $this->render('Offre/back_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/{id}', name: 'back_show')]
    public function showBack(Offre $offre): Response
    {
        return $this->render('Offre/back_show.html.twig', [
            'offre' => $offre,
        ]);
    }

    #[Route('/admin/{id}/edit', name: 'back_edit')]
    public function editBack(Request $request, Offre $offre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Offre modifiée avec succès.');
            return $this->redirectToRoute('offre_front_back_index');
        }

        return $this->render('Offre/back_edit.html.twig', [
            'form' => $form->createView(),
            'offre' => $offre,
        ]);
    }

    #[Route('/admin/{id}/delete', name: 'back_delete', methods: ['POST'])]
    public function deleteBack(Request $request, Offre $offre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $offre->getIdoffre(), $request->request->get('_token'))) {
            $entityManager->remove($offre);
            $entityManager->flush();

            $this->addFlash('success', 'Offre supprimée avec succès.');
        }

        return $this->redirectToRoute('offre_front_back_index');
    }

    #[Route('/admin/{id}/send-sms', name: 'back_send_sms')]
    public function sendSmsBack(Offre $offre, SmsSender $smsSender): Response
    {
        $numero = '+21629912193'; // Ton numéro
        $message = 'La date de début de l\'offre "' . $offre->getTitre() . '" est prévue pour : ' . $offre->getDatedebut();

        $smsSender->sendSms($numero, $message);

        $this->addFlash('success', 'SMS envoyé avec succès !');

        return $this->redirectToRoute('offre_front_back_show', ['id' => $offre->getIdoffre()]);
    }
}