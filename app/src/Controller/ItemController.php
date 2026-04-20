<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Offer;
use App\Form\OfferType;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ItemController extends AbstractController
{
    #[Route('/item/{id}/offer', name: 'app_item_offer')]
    public function offer(
        Item $item,
        OfferRepository $offerRepository,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $offer = new Offer();

        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $existingOffer = $offerRepository->findOneBy([
                'user' => $this->getUser(),
                'item' => $item,
            ]);

            if ($existingOffer) {
                $this->addFlash('danger', 'Vous avez déjà proposé une enchère pour cet objet.');
            } elseif ($offer->getAmount() <= $item->getStartingPrice()) {
                $this->addFlash('danger', 'Votre enchère doit être supérieure au prix de départ.');
            } else {
                $offer->setUser($this->getUser());
                $offer->setItem($item);

                $em->persist($offer);
                $em->flush();

                $this->addFlash('success', 'Enchère enregistrée.');

                return $this->redirectToRoute('app_item_show', [
                    'id' => $item->getId(),
                ]);
            }
        }

        return $this->render('itemcontroller/index.html.twig', [
            'form' => $form->createView(),
            'item' => $item,
        ]);
    }
}