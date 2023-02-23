<?php

namespace App\Controller;

use App\Entity\TypeCompte;
use App\Form\TypeCompteType;
use App\Repository\TypeCompteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/TypeCompte')]
class TypeCompteController extends AbstractController
{
    #[Route('/AllTypeCompte', name: 'typeCompte_index', methods: ['GET'])]
    public function index(TypeCompteRepository $typeCompteRepository): Response
    {
        return $this->render('type_compte/index.html.twig', [
            'type_comptes' => $typeCompteRepository->findAll(),
        ]);
    }
    #[Route('/AllType', name: 'All_types', methods: ['GET'])]
    public function All_types(TypeCompteRepository $typeCompteRepository): Response
    {
        return $this->render('type_compte/all_types.html.twig', [
            'type_comptes' => $typeCompteRepository->findAll(),
        ]);
    }
    #[Route('/addTypeCompte', name: 'typeCompte_create', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeCompteRepository $typeCompteRepository): Response
    {
        $typeCompte = new TypeCompte();
        $form = $this->createForm(TypeCompteType::class, $typeCompte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeCompteRepository->save($typeCompte, true);

            return $this->redirectToRoute('typeCompte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_compte/new.html.twig', [
            'type_compte' => $typeCompte,
            'form' => $form,
        ]);
    }


    #[Route('delete/{id}', name: 'typeCompte_delete', methods: ['POST'])]
    public function delete(Request $request, TypeCompte $typeCompte, TypeCompteRepository $typeCompteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeCompte->getId(), $request->request->get('_token'))) {
            $typeCompteRepository->remove($typeCompte, true);
        }

        return $this->redirectToRoute('typeCompte_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('edit/{id}', name: 'typeCompte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeCompte $typeCompte, TypeCompteRepository $typeCompteRepository): Response
    {
        $form = $this->createForm(TypeCompteType::class, $typeCompte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeCompteRepository->save($typeCompte, true);

            return $this->redirectToRoute('typeCompte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_compte/edit.html.twig', [
            'type_compte' => $typeCompte,
            'form' => $form,
        ]);
    }  

   
    #[Route('show/{id}', name: 'typeCompte_show', methods: ['GET'])]
    public function show(TypeCompte $typeCompte): Response
    {
        return $this->render('type_compte/show.html.twig', [
            'type_compte' => $typeCompte,
        ]);
    }

   
}
