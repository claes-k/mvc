<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\CardDeck;

class ControllerJson
{
    #[Route("/api/quote", name: "api_quote")]
    public function json_quote(): Response
    {
        $date = date('F j, Y');

        $timestamp = date('Y-m-d H:i:s');

        $number = random_int(0, 4);

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
            'date' => $date,
            'timestamp' => $timestamp,
            'quote' => $quotes[$number],
            'author' => $authors[$number]
        ];

        // return new JsonResponse($data);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck", name: "api_deck")]
    public function api_deck(): Response
    {
        $deck = new CardDeck();

        $data = [];

        foreach ($deck->getDeck() as $card) {
            $cardData = [
                "suit" => $card->getSuit(),
                "value" => $card->getValue(),
                "graphic" => $card->getAsString(),
            ];

            $data[] = $cardData;
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "api_deck_shuffle")]
    public function api_deck_shuffle(
        SessionInterface $session
    ): Response {
        $deck = new CardDeck();
        $deck->shuffleCards();
        $session->set("card_deck", $deck);

        $data = [];

        foreach ($deck->getDeck() as $card) {
            $cardData = [
                "suit" => $card->getSuit(),
                "value" => $card->getValue(),
                "graphic" => $card->getAsString(),
            ];

            $data[] = $cardData;
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw", name: "api_deck_draw")]
    public function api_deck_draw(
        SessionInterface $session
    ): Response {
        if ($session->has("card_deck") && $session->has("card_hand")) {
            $deck = $session->get("card_deck");
            $hand = $session->get("card_hand");
        } else {
            $deck = new CardDeck();
            $hand = new CardHand();
        }

        $deck->shuffleCards();
        $hand->addCard($deck->drawCard());

        $session->set("card_deck", $deck);
        $session->set("card_hand", $hand);

        $data = [
            "cards_left" => $deck->getNumberCards(),
        ];

        foreach ($hand->getHand() as $card) {
            $cardData = [
                "suit" => $card->getSuit(),
                "value" => $card->getValue(),
                "graphic" => $card->getAsString(),
            ];

            $data[] = $cardData;
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw/{num<\d+>}", name: "api_deck_draw_num")]
    public function api_deck_draw_num(
        int $num,
        SessionInterface $session
    ): Response {
        if ($session->has("card_deck") && $session->has("card_hand")) {
            $deck = $session->get("card_deck");
            $hand = $session->get("card_hand");
        } else {
            $deck = new CardDeck();
            $hand = new CardHand();
        }

        $number = $deck->getNumberCards();

        if ($num < $number) {
            foreach (range(1, $num) as $i) {
                $deck->shuffleCards();
                $hand->addCard($deck->drawCard());
            }
        }

        $session->set("card_deck", $deck);
        $session->set("card_hand", $hand);

        $data = [
            "cards_left" => $deck->getNumberCards(),
        ];

        foreach ($hand->getHand() as $card) {
            $cardData = [
                "suit" => $card->getSuit(),
                "value" => $card->getValue(),
                "graphic" => $card->getAsString(),
            ];

            $data[] = $cardData;
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
