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
    #[Route('/icecreams', name: 'ice_creams')]
    public function index(IceCreamRepository $repository): Response
    {
        $iceCream = $repository->findAll();

        return $this->render('ice_cream/iceCreams.html.twig', [
            'iceCreams' => $iceCream,
        ]);
    }

    #[Route('/icecream/{id}', name: 'ice_cream')]
    public function read(IceCream $iceCream): Response
    {
        return $this->render('ice_cream/iceCream.html.twig', [
            'iceCream' => $iceCream,
        ]);
    }

    #[Route('/create_ice_cream', name: 'create_ice_cream')]
    public function addIceCream(Request $request, EntityManagerInterface $entityManager): Response
    {
        $iceCream = new IceCream();
        $form = $this->createForm(IceCreamTypeForm::class, $iceCream);
        $form->handleRequest($request);
        $iceCream->setUser($this->getUser());

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

    #[Route('/update_ice_cream/{id}', name: 'update_ice_cream')]
    public function updateIceCream(IceCream $iceCream, Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(IceCreamTypeForm::class, $iceCream);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($iceCream);
            $entityManager->flush();
            $this->addFlash('success', 'Glace modifier avec succes !');
            return $this->redirectToRoute('ice_cream');
        }

        return $this->render('ice_cream/updateIceCream.html.twig', [
            'iceCreamForm' => $form->createView(),
        ]);
    }

    #[Route('/delete_ice_cream/{id}', name: 'delete_ice_cream')]
    public function deleteIceCream(IceCream $iceCream, Request $request, EntityManagerInterface $entityManager)
    {
        if($this->isCsrfTokenValid("SUP". $iceCream->getId(),$request->get('_token'))){
            $entityManager->remove($iceCream);
            $entityManager->flush();
            $this->addFlash('success', 'La suppression a ete effectuee avec succes !');
            return $this->redirectToRoute('ice_cream');
        }
    }
}
