<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\TypeCarnetRepository;
use App\Form\TypeCarnetType;
use App\Entity\TypeCarnet;

#[Route('/type/carnet')]
class TypeCarnetController extends AbstractController
{
    #[Route('/', name: 'app_type_carnet')]
    public function index(): Response
    {
        return $this->render('type_carnet/index.html.twig', [
            'controller_name' => 'TypeCarnetController',
        ]);
    }
    
       
        #[Route('/showcarnets', name: 'showcarnets')]
        public function newcarnet(TypeCarnetRepository $TypeCarnetRepository ): Response
        {
            return $this->render('type_carnet/index.html.twig', [
                'carnets' => $TypeCarnetRepository->findAll(),
            ]);
        }
    
    
        // #[Route('/newtype', name: 'newtype')]
        // public function newtypecarnet(): Response
        // {
        //     return $this->render('type_carnet/ajoutertype.html.twig', [
        //         'controller_name' => 'TypeCarnetController',
        //     ]);
        // }
        // #[Route('/editcard', name: 'editcard')]
        // public function edittypecarnet(): Response
        // {
        //     return $this->render('type_carnet/modifiercarnet.html.twig', [
        //         'controller_name' => 'TypeCarnetController',
        //     ]);
        // }
    
   
    
        #[Route('/remove/{id}', name: 'carnet_remove')]
        public function removeCarnet(ManagerRegistry $doctrine,$id): Response
        {
            $em= $doctrine->getManager();
            $carnets= $doctrine->getRepository(TypeCarnet::class)->find($id);
            $em->remove($carnets);
            $em->flush();
            return $this->redirectToRoute('showcarnets');
        }
    
        #[Route('/addcarnet', name: 'typecarnet_add')]
        public function addtype(ManagerRegistry $doctrine,Request $req): Response {
            $em = $doctrine->getManager();
            $carnets = new TypeCarnet();
            $form = $this->createForm(TypeCarnetType::class,$carnets);
            $form->handleRequest($req);
            if ($form->isSubmitted() && $form->isValid()){
                $em->persist($carnets);
                $em->flush();
                return $this->redirectToRoute('showcarnets');
            }
          
            return $this->renderForm('type_carnet/ajoutertype.html.twig',['formCheque'=>$form]);
        }
    
        #[Route('/{id}', name: 'carnet_update')]
        public function updateCarnet(ManagerRegistry $doctrine,$id,Request $req): Response {
            $em = $doctrine->getManager();
            $carnets = $doctrine->getRepository(TypeCarnet::class)->find($id);
            $form = $this->createForm(TypeCarnetType::class,$carnets);
            $form->handleRequest($req);
            if($form->isSubmitted()&& $form->isValid()){
                $em->persist($carnets);
                $em->flush();
                return $this->redirectToRoute('showcarnets');
            }
            return $this->renderForm('type_carnet/modifiercarnet.html.twig',['carnet' => $carnets,'formCheque'=>$form]);
    
        }
    
}
