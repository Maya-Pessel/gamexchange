<?php

namespace App\Controller;

use App\Entity\Exchange;
use App\Entity\Messages;
use App\Form\MessageType;
use App\Repository\MessagesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessagesController extends AbstractController
{
    /**
     * @Route("/exchange/{id}/messages", name="app_exchange_messages", methods={"GET", "POST"})
     */
    public function exchangeMessages(Exchange $exchange, MessagesRepository $messageRepository, Request $request): Response
    {
        $messages = $messageRepository->findBy(['exchange' => $exchange], ['createdAt' => 'ASC']);
        $message = new Messages();
        $message->setCreatedAt(new \DateTimeImmutable('now'));
        ###### This is the line that causes the error => Faire une many to one######
        $message->setCreatedBy($this->getUser());

        $message->setExchange($exchange);
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('app_exchange_messages', ['id' => $exchange->getId()]);
        }

        return $this->render('messages/exchange_messages.html.twig', [
            'exchange' => $exchange,
            'messages' => $messages,
            'form' => $form->createView(),
        ]);
    }

}