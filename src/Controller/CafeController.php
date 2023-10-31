<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AjoutCafeType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Cafe;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TypeCafeRepository;


class CafeController extends AbstractController
{
    #[Route('/ajoutcafe', name: 'app_cafe')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $cafe = new Cafe();
        $form = $this->createForm(AjoutCafeType::class,$cafe);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $em->persist($cafe);
                $em->flush();
                $this->addFlash('notice','Café ajouté');
                return $this->redirectToRoute('app_cafe');
            }
            }
           
        return $this->render('cafe/index.html.twig', ['form' => $form->createView()
        ]);
    }

    #[Route('/liste-typecafe', name: 'app_liste_typecafe')]
    public function listeCategories(TypeCafeRepository $TypeCafeRepository): Response
    {
        $typecafes = $TypeCafeRepository->findAll();
        return $this->render('cafe/liste-cafe.html.twig', ['typecafes' => $typecafes]);
    }
}
