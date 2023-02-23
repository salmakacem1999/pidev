<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\TypeCarteRepository;
use App\Form\TypeCarteType;
use App\Entity\TypeCarte;


#[Route('/type/carte')]
class TypeCarteController extends AbstractController
{
    #[Route('/', name: 'app_type_carte')]
    public function index(): Response
    {
        return $this->render('type_carte/index.html.twig', [
            'controller_name' => 'TypeCarteController',
        ]);
    }

    #[Route('/newcard', name: 'newcard')]
    public function newcard(TypeCarteRepository $TypeCarteRepository ): Response
    {
        return $this->render('type_carte/cards.html.twig', [
            'cards' => $TypeCarteRepository->findAll(),
        ]);
    }


    #[Route('/newtype', name: 'newtype')]
    public function newtype(): Response
    {
        return $this->render('type_carte/newtypecard.html.twig', [
            'controller_name' => 'TypeCarteController',
        ]);
    }
    #[Route('/editcard', name: 'editcard')]
    public function edittype(): Response
    {
        return $this->render('type_carte/editcard.html.twig', [
            'controller_name' => 'TypeCarteController',
        ]);
    }

    #[Route('/remove/{id}', name: 'card_remove')]
    public function removeCard(ManagerRegistry $doctrine,$id): Response
    {
        $em= $doctrine->getManager();
        $cards= $doctrine->getRepository(TypeCarte::class)->find($id);
        $em->remove($cards);
        $em->flush();
        return $this->redirectToRoute('newcard');
    }

    #[Route('/add', name: 'type_add')]
    public function addtype(ManagerRegistry $doctrine,Request $req): Response {
        $em = $doctrine->getManager();
        $cards = new TypeCarte();

        $form = $this->createForm(TypeCarteType::class,$cards);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($cards);
            $em->flush();
            return $this->redirectToRoute('newcard');
        }
      
        return $this->renderForm('type_carte/newtypecard.html.twig',['formCard'=>$form]);
    }

    #[Route('/{id}', name: 'card_update')]
    public function updateClub(ManagerRegistry $doctrine,$id,Request $req): Response {
        $em = $doctrine->getManager();
        $cards = $doctrine->getRepository(TypeCarte::class)->find($id);
        $form = $this->createForm(TypeCarteType::class,$cards);
        $form->handleRequest($req);
        if($form->isSubmitted()&& $form->isValid()){
            $em->persist($cards);
            $em->flush();
            return $this->redirectToRoute('newcard');
        }
        return $this->renderForm('type_carte/editcard.html.twig',['card' => $cards,'formCard'=>$form]);

    }


}
