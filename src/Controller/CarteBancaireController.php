<?php

namespace App\Controller;

use App\Entity\CarteBancaire;
use App\Form\CarteBancaireType;
use App\Repository\CarteBancaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/carte/bancaire')]
class CarteBancaireController extends AbstractController
{
    #[Route('/', name: 'app_carte_bancaire_index', methods: ['GET'])]
    public function index(CarteBancaireRepository $carteBancaireRepository): Response
    {
        return $this->render('carte_bancaire/index.html.twig', [
            'carte_bancaires' => $carteBancaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_carte_bancaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarteBancaireRepository $carteBancaireRepository,SluggerInterface $slugger): Response
    {
        $carteBancaire = new CarteBancaire();
        $carteBancaire->setStatus('En cours');
        $form = $this->createForm(CarteBancaireType::class, $carteBancaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image1 = $form->get('cinS1')->getData();
            $image2 = $form->get('cinS2')->getData();
            if ($image1) {
                $originalFilename = pathinfo($image1->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$image1->guessExtension();
                try {
                    $image1->move(
                        $this->getParameter('brochures_directory2'),
                        $newFilename
                    );
                } catch (FileException $e) {
                
                }
              $carteBancaire->setCinS1($newFilename);
            }
            
            if ($image2) {
                $originalFilename = pathinfo($image2->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$image2->guessExtension();
                try {
                    $image2->move(
                        $this->getParameter('brochures_directory2'),
                        $newFilename
                    );
                } catch (FileException $e) {
                
                }
              $carteBancaire->setCinS2($newFilename);
            }
            $carteBancaireRepository->save($carteBancaire, true);

            return $this->redirectToRoute('app_carte_bancaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carte_bancaire/new.html.twig', [
            'carte_bancaire' => $carteBancaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_carte_bancaire_show', methods: ['GET'])]
    public function show(CarteBancaire $carteBancaire): Response
    {
        return $this->render('carte_bancaire/show.html.twig', [
            'carte_bancaire' => $carteBancaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_carte_bancaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CarteBancaire $carteBancaire, CarteBancaireRepository $carteBancaireRepository): Response
    {
        $form = $this->createForm(CarteBancaireType::class, $carteBancaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carteBancaireRepository->save($carteBancaire, true);

            return $this->redirectToRoute('app_carte_bancaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carte_bancaire/edit.html.twig', [
            'carte_bancaire' => $carteBancaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_carte_bancaire_delete', methods: ['POST'])]
    public function delete(Request $request, CarteBancaire $carteBancaire, CarteBancaireRepository $carteBancaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carteBancaire->getId(), $request->request->get('_token'))) {
            $carteBancaireRepository->remove($carteBancaire, true);
        }

        return $this->redirectToRoute('app_carte_bancaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
