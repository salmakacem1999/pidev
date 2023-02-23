<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CarnetChequeRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\CarnetCheque;

#[Route('/list/demande/carnet')]
class ListDemandeCarnetController extends AbstractController
{
    #[Route('/', name: 'app_list_demande_carnet')]
    public function index(): Response
    {
        return $this->render('list_demande_carnet/index.html.twig', [
            'controller_name' => 'ListDemandeCarnetController',
        ]);
    }
 
    // #[Route('/carnetdetails', name: 'carnetdetails')]
    // public function admindetails(): Response
    // {
    //     return $this->render('list_demande_carnet/detailscarnet.html.twig', [
    //         'controller_name' => 'ListDemandeCarnetController',
    //     ]);
    // }
    #[Route('/carnetdetails/{id}', name: 'carnetdetails', methods: ['GET'])]
    public function show(CarnetCheque $carnetcheque): Response
    {
        return $this->render('list_demande_carnet/detailscarnet.html.twig', [
            'carnet' => $carnetcheque,
        ]);
    }

    #[Route('/servicecarnet', name: 'servicecarnet', methods: ['GET'])]
    public function ListDemendeCarnets(CarnetChequeRepository $CarnetChequeRepository): Response
    {
        return $this->render('list_demande_carnet/index.html.twig', [          
            'carnets' => $CarnetChequeRepository->findAll(),
        ]);
    }
    #[Route('accept/{id}', name: 'acceptcarnet', methods: ['POST'])]
    public function accept(Request $request, CarnetCheque $carnetcheque, CarnetChequeRepository $CarnetChequeRepository): Response
    {
        if ($this->isCsrfTokenValid('Approve'.$carnetcheque->getId(), $request->request->get('_token'))) {
              $carnetcheque->setStatus('accepté');
              $CarnetChequeRepository->save($carnetcheque, true);

        }

        return $this->redirectToRoute('servicecarnet', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('refuser/{id}', name: 'refusercarnet', methods: ['POST'])]
    public function refuser(Request $request, CarnetCheque $carnetcheque, CarnetChequeRepository $CarnetChequeRepository): Response
    {
        if ($this->isCsrfTokenValid('Reject'.$carnetcheque->getId(), $request->request->get('_token'))) {
              $carnetcheque->setStatus('refusé');
              $CarnetChequeRepository->save($carnetcheque, true);

        }

        return $this->redirectToRoute('servicecarnet', [], Response::HTTP_SEE_OTHER);
    }
}
