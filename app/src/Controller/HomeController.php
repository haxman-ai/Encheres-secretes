<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpCache\ResponseCacheStrategy;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ItemRepository $itemRepository, CategoryRepository $categoryRepository ,): Response
    {
       $items = $itemRepository->findPublishedOrClosed();

        return $this->render('home/index.html.twig', [
            'items' => $items,
        ]);
    }


    #[Route('/item/{id}',name:'app_item_show')]
    public function show(int $id, ItemRepository $itemRepository,): Response
    {  
        $item = $itemRepository->find($id);

        if(!$item){
            throw $this->createNotFoundException('objet introuvable.');
        }

        return $this->render('home/show.html.twig',[
               
            'item'=>$item,
            
        ]);


    }

}