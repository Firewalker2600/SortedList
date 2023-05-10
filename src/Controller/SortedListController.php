<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortedListController
{
    #[Route('/')]
    public function home(): Response
    {
        return new Response('Fancier way to return SortedList experience.');
    }

    #[Route('/sorted-list/{order}')]
    public function sortedList(string $order = null): Response
    {
        return new Response('Lets start working with SortedList already in ' . $order . ' order');
    }

}