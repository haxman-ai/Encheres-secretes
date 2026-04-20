<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
#[Route('/', name: 'app_home')]
public function index(
    Request $request,
    ItemRepository $itemRepository,
    CategoryRepository $categoryRepository
): Response {
    $categories = $categoryRepository->findAll();

    $categoryId = $request->query->get('category');
    $category = null;

    if ($categoryId) {
        $category = $categoryRepository->find($categoryId);
        $items = $itemRepository->findByCategory($category);
    } else {
        $items = $itemRepository->findPublishedOrClosed();
    }

    return $this->render('home/index.html.twig', [
        'items' => $items,
        'categories' => $categories,
    ]);
}

#[Route('/item/{id}', name: 'app_item_show')]
public function show(int $id, ItemRepository $itemRepository): Response
{
    $item = $itemRepository->find($id);

    if (!$item) {
        throw $this->createNotFoundException('objet introuvable.');
    }

    return $this->render('home/show.html.twig', [
        'item' => $item,
    ]);
}


}