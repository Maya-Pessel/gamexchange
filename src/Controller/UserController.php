<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;



class UserController extends AbstractController
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/user/{id}', name: 'app_user_profile')]
    public function userProducts(User $user, ProductRepository $productRepository): Response
    {
        $user = $this->security->getUser();
        $products = $productRepository->findBy(['user' => $user], ['id' => 'DESC']);

        return $this->render('user/profile.html.twig', [
            'products' => $products,
            'user' => $user
        ]);
    }

    #[Route('/user/{id}/update', name: 'app_user_update')]
    public function editUser(User $user, Request $request, EntityManagerInterface $em): Response
    {
        if ($user !== $this->security->getUser()) {
            throw $this->createAccessDeniedException('You are not the owner of this profile');
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Profile successfully updated');

            return $this->redirectToRoute('app_user_profile', ['id' => $user->getId()]);
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}
