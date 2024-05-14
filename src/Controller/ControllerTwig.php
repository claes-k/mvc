<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ControllerTwig extends AbstractController
{
    #[Route("/", name: "index")]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {
        $number = random_int(0, 4);

        $photos = [
            "barnstar.jpg",
            "four_leaf_clover.jpg",
            "good_luck_charms.jpg",
            "horseshoe.jpg",
            "maneki_neko.jpg"
        ];

        $quotes = [
            "You never know what worse luck your bad luck has saved you from.",
            "You know, Hobbes, some days even my lucky rocket ship underpants don't help.",
            "Remember that sometimes not getting what you want is a wonderful stroke of luck.",
            "Oh, I am fortune's fool!",
            "We are all a great deal luckier that we realize, we usually get what we want - or near enough."];

        $authors = [
            "Cormac McCarthy, No Country for Old Men",
            "Bill Watterson",
            "Dalai Lama",
            "William Shakespeare, Romeo and Juliet",
            "Roald Dahl, Charlie and the Chocolate Factory"
        ];

        $data = [
            'photo' => $photos[$number],
            'quote' => $quotes[$number],
            'author' => $authors[$number]
        ];

        return $this->render('lucky.html.twig', $data);
    }

    #[Route("/api", name: "api")]
    public function api(): Response
    {
        return $this->render('api.html.twig');
    }

    // #[Route("/api/quote", name: "quote")]
    // public function quote(): Response
    // {
    //     return $this->render('quote.html.twig');
    // }

    #[Route("/card", name: "card")]
    public function card(): Response
    {
        return $this->render('card.html.twig');
    }

    #[Route("/session", name: "session")]
    public function session(
        SessionInterface $session
    ): Response {
        if ($session->has("card_deck") && $session->has("card_hand")) {
            $deck = $session->get("card_deck");
            $deck_string = $deck->getString();
            $hand = $session->get("card_hand");
            $hand_string = $hand->getString();

            $data = [
                "deck" => $deck_string,
                "hand" => $hand_string,
            ];
            return $this->render('session.html.twig', $data);
        } else {
            return $this->render('session.html.twig');
        }
    }

    #[Route("/session/delete", name: "session_delete")]
    public function sessionDelete(
        SessionInterface $session
    ): Response {
        session_start();
        $session = array();
        session_destroy();

        $this->addFlash(
            'warning',
            'Session has been deleted!'
        );

        return $this->redirectToRoute('session');
    }
}
