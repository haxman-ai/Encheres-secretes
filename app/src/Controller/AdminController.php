<?php

namespace App\Controller;

use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Item;

final class AdminController extends AbstractController
{
    #[Route('/admin/item/{id}', name: 'app_admin_show')]
    public function show(Item $item): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/show.html.twig', [
            'item' => $item,
        ]);
    }
     

  #[Route('/admin/item/{id}/toggle', name: 'app_admin_toggle')]
   public function toggle(Item $item, EntityManagerInterface $em): Response
    {
    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    if ($item->getStatus() === 'unpublished') {
        $item->setStatus('published');
        $this->addFlash('success', "L'objet a été publié.");
    } elseif ($item->getStatus() === 'published') {
        if ($item->getOffers()->count() === 0) {
            $item->setStatus('unpublished');
            $this->addFlash('success', "L'objet a été dépublié.");
        } else {
            $this->addFlash('danger', "Impossible de dépublier un objet qui a déjà des enchères.");
        }
    }

        $em->flush();

        return $this->redirectToRoute('app_admin_show', [
            'id' => $item->getId(),
            
        ]);
            }
            #[Route('/admin', name: 'app_admin_list')]
        public function list(ItemRepository $itemRepository): Response
        {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            $items = $itemRepository->findAll();
            return $this->render('admin/list.html.twig', [
                'items' => $items,
            ]);
        }

        #[Route('/admin/item/{id}/close', name: 'app_admin_close')]
public function close(Item $item, EntityManagerInterface $em): Response
{
    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    if ($item->getStatus() === 'published' && $item->getOffers()->count() > 0) {
        $bestOffer = null;
        foreach ($item->getOffers() as $offer) {
            if ($bestOffer === null || $offer->getAmount() > $bestOffer->getAmount()) {
                $bestOffer = $offer;
            }
        }
        $item->setStatus('closed');
        $item->setWinner($bestOffer->getUser());
        $em->flush();
        $this->addFlash('success', 'Enchère fermée ! Gagnant : ' . $bestOffer->getUser()->getEmail());
    }

    return $this->redirectToRoute('app_admin_show', ['id' => $item->getId()]);
}
         
} 
    



