<?php

namespace App\Controller;

use App\Entity\Exchange;
use App\Entity\Product;
use App\Entity\Status;
use App\Form\ExchangeStatusType;
use App\Form\ExchangeType;
use App\Repository\ExchangeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ExchangeController extends AbstractController
{
    /**
     * @Route("/product/{id<[0-9]+>}/show-exchange", name="app_product_exchanges", methods="GET|POST")
     */
    public function showExchanges(Product $product, ExchangeRepository $exchangeRepository): Response
    {
        $exchanges = $exchangeRepository->exchangesForProduct($product);

        return $this->render('exchange/show-exchange.html.twig', [
            'product' => $product,
            'exchanges' => $exchanges,
        ]);
    }


    /**
     * @Route("/product/{id<[0-9]+>}/create-exchange", name="app_product_exchange", methods="GET|POST")
     */
    public function exchange(Product $product, Request $request, EntityManagerInterface $em, UserInterface $user, ExchangeRepository $exchangeRepository): Response
    {
        $form = $this->createForm(ExchangeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productId2 = $form->get('productId2')->getData();

            // Check if an exchange already exists between the two products
            $existingExchange = $exchangeRepository->findOneBy(['productId1' => $product, 'productId2' => $productId2]);
            if ($existingExchange && $existingExchange->getStatus()->getName() !== 'Canceled') {
                $this->addFlash('error', 'An exchange already exists between these products');
                return $this->redirectToRoute('app_home');
            } elseif ($existingExchange && $existingExchange->getStatus()->getName() === 'Canceled') {
                $existingExchange->setStatus($em->getRepository(Status::class)->findOneBy(['name' => 'Pending']));
                $em->flush();
                $this->addFlash('success', 'Exchange successfully created');
                return $this->redirectToRoute('app_home');
            }

            $exchange = new Exchange();
            $exchange->setProductId1($product);
            $exchange->setProductId2($productId2);
            $exchange->setCreatedBy($user);

            // Set status to Pending
            $status = $em->getRepository(Status::class)->findOneBy(['name' => 'Pending']);
            $exchange->setStatus($status);

            $em->persist($exchange);
            $em->flush();

            $this->addFlash('success', 'Exchange successfully created');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('exchange/create_exchange.html.twig', [
            'form' => $form->createView(),
            'product' => $product
        ]);
    }


    /**
     * @Route("/exchange/{id<[0-9]+>}/edit-status", name="app_exchange_edit_status", methods="GET|POST")
     */
    public function editExchangeStatus(Exchange $exchange, Request $request, EntityManagerInterface $em, UserInterface $user): Response
    {

        # check if the user is the creator of the exchange and if he is the creator of the exchange he can't change the status except to cancel
        if ($exchange->getCreatedBy() === $user && $exchange->getStatus()->getName() !== 'Cancelled') {
            $this->addFlash('error', 'You can\'t change the status of this exchange');
            return $this->redirectToRoute('app_home');
        }

        # check if the exchange is already accepted or declined
        if ($exchange->getStatus()->getName() === 'Accepted' || $exchange->getStatus()->getName() === 'Declined') {
            $this->addFlash('error', 'This exchange is already accepted or declined');
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(ExchangeStatusType::class, $exchange);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Exchange status successfully updated');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('exchange/edit_status.html.twig', [
            'form' => $form->createView(),
            'exchange' => $exchange,

        ]);
    }

    /**
     * @Route("/exchange/{id}/cancel", name="app_exchange_cancel", methods={"GET"})
     */
    public function cancelExchange(Exchange $exchange, EntityManagerInterface $entityManager): Response
    {
        $status = $entityManager->getRepository(Status::class)->findOneBy(['name' => 'Canceled']);

        if (!$status) {
            throw $this->createNotFoundException('The status "Cancelled" does not exist.');
        }

        $exchange->setStatus($status);
        $entityManager->flush();

        $this->addFlash('success', 'The exchange has been cancelled.');

        return $this->redirectToRoute('app_product_exchanges', ['id' => $exchange->getId()]);
    }
}
