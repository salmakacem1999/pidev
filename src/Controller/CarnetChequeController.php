<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\CarnetCheque;
use App\Form\CarnetChequeType;
use App\Repository\CarnetChequeRepository;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;




#[Route('/carnet/cheque')]
class CarnetChequeController extends AbstractController
{
    #[Route('/', name: 'app_carnet_cheque_index')]
    public function index(CarnetChequeRepository $CarnetChequeRepository): Response
    {
        return $this->render('carnet_cheque/index.html.twig', [
            'carnet_cheques' => $CarnetChequeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_carnet_cheque_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarnetChequeRepository $CarnetChequeRepository,SluggerInterface $slugger): Response
    {
        $carnetcheque = new CarnetCheque();
        $carnetcheque->setStatus('En cours');
        $form = $this->createForm(CarnetChequeType::class, $carnetcheque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image1 = $form->get('cinS1')->getData();
            $image2 = $form->get('cinS2')->getData();
            $image3 = $form->get('document')->getData();
            if ($image1) {
                $originalFilename = pathinfo($image1->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$image1->guessExtension();
                try {
                    $image1->move(
                        $this->getParameter('brochures_directory3'),
                        $newFilename
                    );
                } catch (FileException $e) {
                
                }
            $carnetcheque->setCinS1($newFilename);
            }
            
            if ($image2) {
                $originalFilename = pathinfo($image2->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$image2->guessExtension();
                try {
                    $image2->move(
                        $this->getParameter('brochures_directory3'),
                        $newFilename
                    );
                } catch (FileException $e) {
                
                }
                $carnetcheque->setCinS2($newFilename);
            }
            if ($image3) {
                $originalFilename = pathinfo($image3->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$image3->guessExtension();
                try {
                    $image3->move(
                        $this->getParameter('brochures_directory3'),
                        $newFilename
                    );
                } catch (FileException $e) {
                
                }
            $carnetcheque->setDocument($newFilename);
            }

            $CarnetChequeRepository->save($carnetcheque, true);

            return $this->redirectToRoute('app_carnet_cheque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carnet_cheque/new.html.twig', [
            'carnet_cheque' => $carnetcheque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_carnet_cheque_show', methods: ['GET'])]
    public function show(CarnetCheque $carnetcheque): Response
    {
        return $this->render('carnet_cheque/show.html.twig', [
            'carnet_cheque' => $carnetcheque,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_carnet_cheque_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CarnetCheque $carnetcheque, CarnetChequeRepository $carnetChequeRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(CarnetChequeType::class, $carnetcheque);
        $form->handleRequest($request);

        // Get the existing image file names
        $cinS1Filename = $carnetcheque->getCinS1();
        $cinS2Filename = $carnetcheque->getCinS2();
        $documentFilename = $carnetcheque->getDocument();
      


        if ($form->isSubmitted() && $form->isValid()) {

            $image1 = $form->get('cinS1')->getData();
            $image2 = $form->get('cinS2')->getData();
            $image3 = $form->get('document')->getData();
            if ($image1) {
                $originalFilename = pathinfo($image1->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$image1->guessExtension();
                try {
                    $image1->move(
                        $this->getParameter('brochures_directory3'),
                        $newFilename
                    );
                } catch (FileException $e) {
                
                }
            $carnetcheque->setCinS1($newFilename);
            }else {
                // Si aucune nouvelle image n'est téléchargée, conserver le nom de fichier de l'image actuelle
                $carnetcheque->setCinS1($cinS1Filename);
            }
            
            if ($image2) {
                $originalFilename = pathinfo($image2->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$image2->guessExtension();
                try {
                    $image2->move(
                        $this->getParameter('brochures_directory3'),
                        $newFilename
                    );
                } catch (FileException $e) {
                
                }
                $carnetcheque->setCinS2($newFilename);
            }else {
                // Si aucune nouvelle image n'est téléchargée, conserver le nom de fichier de l'image actuelle
                $carnetcheque->setCinS2($cinS2Filename);
            }
            if ($image3) {
                $originalFilename = pathinfo($image3->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$image3->guessExtension();
                try {
                    $image3->move(
                        $this->getParameter('brochures_directory3'),
                        $newFilename
                    );
                } catch (FileException $e) {
                
                }
            $carnetcheque->setDocument($newFilename);
            }else {
                // Si aucune nouvelle image n'est téléchargée, conserver le nom de fichier de l'image actuelle
                $carnetcheque->setDocument($documentFilename);
            }


            $carnetChequeRepository->save($carnetcheque, true);

            return $this->redirectToRoute('app_carnet_cheque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carnet_cheque/edit.html.twig', [
            'carnet_cheque' => $carnetcheque,
            'form' => $form,
            'cinS1Filename' => $cinS1Filename,
            'cinS2Filename' => $cinS2Filename,
            'documentFilename' => $documentFilename,
            
            
        ]);
    }

    #[Route('/{id}', name: 'app_carnet_cheque_delete', methods: ['POST'])]
    public function delete(Request $request, CarnetCheque $carnetcheque, CarnetChequeRepository $carnetChequeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carnetcheque->getId(), $request->request->get('_token'))) {
            $carnetChequeRepository->remove($carnetcheque, true);
        }

        return $this->redirectToRoute('app_carnet_cheque_index', [], Response::HTTP_SEE_OTHER);
    }
}
