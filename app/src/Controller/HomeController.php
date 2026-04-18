<?php

namespace App\Controller;

use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ItemRepository $itemRepository): Response
    {
        $items = $itemRepository->findBy([
            'status' => 'published'
        ]);

        return $this->render('home/index.html.twig', [
            'items' => $items,
        ]);
    }
}