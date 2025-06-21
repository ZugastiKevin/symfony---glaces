<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserTypeForm;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route('/user/{id}', name: 'user')]
    public function index(User $user): Response
    {
        return $this->render('security/user.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/create_user', name: 'create_user')]
    public function addUser(Request $request, UserRepository $repository, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $user = new User();

        $form = $this->createForm(UserTypeForm::class, $user);
        $form->handleRequest($request);
        $user->setRoles(['ROLE_USER']);

        if($form->isSubmitted() && $form->isValid()){
            
            $exist = $repository->findOneBy(['email' => $user->getEmail()]);
            if ($exist) {
                $this->addFlash('error', 'Un compte avec cet email existe déjà.');
                return $this->redirectToRoute('create_user');
            }

            $user->setPassword(
                $passwordEncoder->hashPassword($user,$form->get('password')->getData())
            );

            $entityManager->persist($user);
            $entityManager->flush();
                
            return $this->redirectToRoute('ice_creams');
        }

        return $this->render('security/addUser.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    #[Route('/update_user/{id}', name: 'update_user')]
    public function updateUser(User $user, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder): Response
    {

        $form = $this->createForm(UserTypeForm::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user->setPassword(
                $passwordEncoder->hashPassword($user,$form->get('password')->getData())
            );

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('ice_creams');
        }

        return $this->render('security/updateUser.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    #[Route('/delete_user/{id}', name: 'delete_user')]
    public function deleteUser(User $user, Request $request, EntityManagerInterface $entityManager)
    {
        if($this->isCsrfTokenValid("SUP". $user->getId(),$request->get('_token'))){
            $entityManager->remove($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
