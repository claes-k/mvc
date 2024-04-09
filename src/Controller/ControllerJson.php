<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControllerJson
{
    #[Route("/api/quote", name: "quote")]
    public function jsonQuote(): Response
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
}