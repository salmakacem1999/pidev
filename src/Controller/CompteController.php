<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Form\CompteType;
use App\Repository\CompteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/compte')]
class CompteController extends AbstractController
{
   /****USER****/

    #[Route('/compte_all', name: 'All_comptes')]
    public function index(CompteRepository $compteRepository): Response
    {
        return $this->render('compte/index.html.twig', [
            'comptes' => $compteRepository->findAll(),
        ]);
    }

    #[Route('/createAccount', name: 'compte_create', methods: ['GET', 'POST'])]
    public function new(Request $request, CompteRepository $compteRepository,SluggerInterface $slugger): Response
    {
        $compte = new Compte();
        $form = $this->createForm(CompteType::class, $compte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image1 = $form->get('cinS1')->getData();
            $image2 = $form->get('cinS2')->getData();
            $image3 = $form->get('otherDoc')->getData();
            if ($image1) {
                $originalFilename = pathinfo($image1->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$image1->guessExtension();
                try {
                    $image1->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                
                }
              $compte->setCinS1($newFilename);
            }
            
            if ($image2) {
                $originalFilename = pathinfo($image2->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$image2->guessExtension();
                try {
                    $image2->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                
                }
              $compte->setCinS2($newFilename);
            }
            if ($image3) {
                $originalFilename = pathinfo($image3->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$image3->guessExtension();
                try {
                    $image3->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                
                }
              $compte->setOtherDoc($newFilename);
            }
            $compte->setRib("xxxxxx");   
            $compte->setSolde("xxxxxx");
            $compte->setSolde("in progress");
            $compteRepository->save($compte, true);

            return $this->redirectToRoute('All_comptes', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('compte/create.html.twig', [
            'compte' => $compte,            
            'form' => $form,
        ]);
    }

    #[Route('/details/{id}', name: 'compte_details', methods: ['GET'])]
    public function show(Compte $compte): Response
    {
        return $this->render('compte/details.html.twig', [
            'compte' => $compte,
        ]);
    }
    

    #[Route('/delete/{id}', name: 'app_compte_delete', methods: ['POST'])]
    public function deleteAdmin(Request $request, Compte $compte, CompteRepository $compteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$compte->getId(), $request->request->get('_token'))) {
            $compteRepository->remove($compte, true);
        }

        return $this->redirectToRoute('All_comptes', [], Response::HTTP_SEE_OTHER);
    }
    /***********Admin*******/ 

    #[Route('/account_Deposit', name: 'all_deposits')]
    public function requestAccount(CompteRepository $compteRepository): Response
    {
        return $this->render('compte/accountDeposit_Ad.html.twig', [
            'comptes' => $compteRepository->findAll(),
        ]);
    }
    
    #[Route('edit/{id}', name: 'compte_editAdmin', methods: ['GET', 'POST'])]
    public function validerCompte(Request $request, Compte $compte, CompteRepository $compteRepository): Response
    {
        $form = $this->createForm(CompteType::class, $compte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $compteRepository->save($compte, true);

            return $this->redirectToRoute('all_deposits', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('compte/edit_Ad.html.twig', [
            'compte' => $compte,
            'form' => $form,
        ]);
    }

}
