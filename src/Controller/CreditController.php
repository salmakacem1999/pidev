<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreditController extends AbstractController
{
    #[Route('/credits', name: 'credits')]
    public function index(): Response
    {
        return $this->render('credit/credits.html.twig', [
            'controller_name' => 'CreditController',
        ]);
    }
    #[Route('/loans', name: 'loans')]
    public function loans(): Response
    {
        return $this->render('credit/loans.html.twig', [
            'controller_name' => 'CreditController',
        ]);
    }

    #[Route('/applyCredit', name: 'credit_create')]
    public function apply(): Response
    {
        return $this->render('credit/create.html.twig', [
            'controller_name' => 'CreditController',
        ]);
    }

    #[Route('/detailsCredit', name: 'credit_details')]
    public function details(): Response
    {
        return $this->render('credit/details.html.twig', [
            'controller_name' => 'CreditController',
        ]);
    }
}
