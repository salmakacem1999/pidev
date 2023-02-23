<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CarteBancaireRepository;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\CarteBancaire;

#[Route('/list/demande/carte')]
class ListDemandeCarteController extends AbstractController
{
    #[Route('/', name: 'app_list_demande_carte')]
    public function index(): Response
    {
        return $this->render('list_demande_carte/index.html.twig', [
            'controller_name' => 'ListDemandeCarteController',
        ]);
    }
    // #[Route('/adminservice', name: 'service_admin')]
    // public function adminservice(): Response
    // {
    //     return $this->render('list_demande_carte/index.html.twig', [
    //         'controller_name' => 'ListDemandeCarteController',
    //     ]);
    // }
    // #[Route('/detailsadmin', name: 'serviceadmin_details')]
    // public function admindetails(): Response
    // {
    //     return $this->render('list_demande_carte/detailscarte.html.twig', [
    //         'controller_name' => 'ListDemandeCarteController',
    //     ]);
    // }
    #[Route('/servicecarte', name: 'servicecarte', methods: ['GET'])]
    public function ListDemendeCartes(CarteBancaireRepository $CarteBancaireRepository): Response
    {
        return $this->render('list_demande_carte/index.html.twig', [          
            'cartes' => $CarteBancaireRepository->findAll(),
        ]);
    }
    #[Route('/cartedetails/{id}', name: 'cartedetails', methods: ['GET'])]
    public function show(CarteBancaire $carteBancaire): Response
    {
        return $this->render('list_demande_carte/detailscarte.html.twig', [
            'carte' => $carteBancaire,
        ]);
    }

    #[Route('accept/{id}', name: 'acceptcarte', methods: ['POST'])]
    public function accept(Request $request, CarteBancaire $carteBancaire, CarteBancaireRepository $CarteBancaireRepository): Response
    {
        if ($this->isCsrfTokenValid('Approve'.$carteBancaire->getId(), $request->request->get('_token'))) {
              $carteBancaire->setStatus('accepté');
              $CarteBancaireRepository->save($carteBancaire, true);

        }

        return $this->redirectToRoute('servicecarte', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('refuser/{id}', name: 'refusercarte', methods: ['POST'])]
    public function refuser(Request $request, CarteBancaire $carteBancaire, CarteBancaireRepository $CarteBancaireRepository): Response
    {
        if ($this->isCsrfTokenValid('Reject'.$carteBancaire->getId(), $request->request->get('_token'))) {
              $carteBancaire->setStatus('refusé');
              $CarteBancaireRepository->save($carteBancaire, true);

        }

        return $this->redirectToRoute('servicecarte', [], Response::HTTP_SEE_OTHER);
    }

}
