<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\CardDeck;

class CardGameController extends AbstractController
{
    #[Route("/card/deck", name: "card_deck")]
    public function deck(): Response
    {
        $deck = new CardDeck();

        $data = [
            "cards" => $deck->getString(),
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "card_deck_shuffle")]
    public function deck_shuffle(
        SessionInterface $session
    ): Response {
        $deck = new CardDeck();
        $deck->shuffleCards();

        $hand = new CardHand();

        $session->set("card_deck", $deck);
        $session->set("card_hand", $hand);

        $data = [
            "cards" => $deck->getString(),
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_deck_draw")]
    public function deck_draw(
        SessionInterface $session
    ): Response {
        // if (!isset($_SESSION["card_deck"]) && !isset($_SESSION["card_hand"])) {
        if ($session->has("card_deck") && $session->has("card_hand")) {
            $deck = $session->get("card_deck");
            $hand = $session->get("card_hand");
            // echo "Test";
        } else {
            $deck = new CardDeck();
            $hand = new CardHand();
            // echo "New";
        }

        $deck->shuffleCards();
        $hand->addCard($deck->drawCard());

        $session->set("card_deck", $deck);
        $session->set("card_hand", $hand);

        $data = [
            "cards" => $hand->getString(),
            "number" => $deck->getNumberCards(),
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "card_deck_draw_num")]
    public function deck_draw_num(
        int $num,
        SessionInterface $session
    ): Response {
        if ($session->has("card_deck") && $session->has("card_hand")) {
            $deck = $session->get("card_deck");
            $hand = $session->get("card_hand");
            // echo "Test<br>";
        } else {
            $deck = new CardDeck();
            $hand = new CardHand();
            // echo "New<br>";
        }

        $number = $deck->getNumberCards();
        // echo $num;
        // echo "<br>";

        if ($num > $number) {
            $this->addFlash(
                'warning',
                'Not enough cards in the deck!'
            );
        } else {
            foreach (range(1, $num) as $i) {
                $deck->shuffleCards();
                $hand->addCard($deck->drawCard());
            }
        }

        // echo $deck->getNumberCards();
        // echo "<br>";

        $session->set("card_deck", $deck);
        $session->set("card_hand", $hand);

        $data = [
            "cards" => $hand->getString(),
            "number" => $deck->getNumberCards(),
        ];

        return $this->render('card/deck.html.twig', $data);
    }
}
