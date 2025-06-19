<?php

namespace App\Controller;

use App\Entity\IceCream;
use App\Form\IceCreamTypeForm;
use App\Repository\IceCreamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class IceCreamController extends AbstractController
{
    #[Route('/icecream', name: 'ice_cream')]
    public function index(IceCreamRepository $repository): Response
    {
        $iceCream = $repository->findAll();

        return $this->render('ice_cream/iceCream.html.twig', [
            'iceCreams' => $iceCream,
        ]);
    }

    #[Route('/create_ice_cream', name: 'create_ice_cream')]
    public function addIceCream(Request $request, EntityManagerInterface $entityManager): Response
    {
        $iceCream = new IceCream();
        $form = $this->createForm(IceCreamTypeForm::class, $iceCream);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($iceCream);
            $entityManager->flush();
            $this->addFlash('success', 'Glace ajoute avec succes !');
            return $this->redirectToRoute('ice_cream');
        }

        return $this->render('ice_cream/addIceCream.html.twig', [
            'iceCreamForm' => $form->createView(),
        ]);
    }
}
