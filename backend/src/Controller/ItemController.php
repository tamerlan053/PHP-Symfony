<?php

namespace App\Controller;

use Knp\Component\Pager\PaginatorInterface;
use App\Form\ItemType;
use App\Entity\Item;
use App\Repository\ItemRepository;
use App\Service\ItemService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

final class ItemController extends AbstractController
{
    // (a) Toon alle artikelen en filter op naam
    // Item -> user_id OneToMany => ManyToOne
    #[Route('/artikelen', name: 'item_index')]
    public function index(Request $request, ItemRepository $itemRepository, PaginatorInterface $paginator): Response
    {
        $search = $request->query->get('search', '');
        $user = $this->getUser();

        if (!$user instanceof \App\Entity\User) {
            throw $this->createAccessDeniedException('Alleen ingelogde gebruikers kunnen artikelen bekijken.');
        }

        $query = $itemRepository->getQueryByUserAndNamePrefix($user, $search);

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('item/index.html.twig', [
            'items' => $pagination,
            'search' => $search,
        ]);
    }

    // (b) Voeg een artikel toe
    #[Route('/artikelen/toevoegen', name: 'item_add')]
    public function add(Request $request, ItemService $itemService): Response
    {
        $user = $this->getUser();
        if (!$user instanceof \App\Entity\User) {
            throw $this->createAccessDeniedException('Alleen ingelogde gebruikers kunnen artikelen toevoegen.');
        }

        $item = new Item();
        $item->setUser($user);

        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemService->save($item);

            return $this->redirectToRoute('item_index');
        }

        return $this->render('item/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // (c) Wijzig een bestaand artikel
    #[Route('/artikelen/wijzigen/{id}', name: 'item_edit')]
    public function edit(Request $request, Item $item, ItemService $itemService): Response
    {
        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $itemService->save($item);

            $this->addFlash('success', sprintf('Artikel "%s" is gewijzigd.', $item->getName()));
            return $this->redirectToRoute('item_index');
        }

        return $this->render('item/edit.html.twig', [
            'form' => $form->createView(),
            'editMode' => true,
            'item' => $item,
        ]);
    }

    #[Route('/artikelen/quantity/update/{id}', name: 'item_quantity_update', methods: ['POST'])]
    public function updateQuantity(Request $request, Item $item, ItemService $itemService): Response
    {
        $newQuantity = $request->request->getInt('quantity');

        if ($newQuantity < 0) {
            $this->addFlash('error', 'Aantal kan niet negatief zijn');
            return $this->redirectToRoute('item_index');
        }

        $itemService->updateQuantity($item, $newQuantity);

        $this->addFlash('success', sprintf('Aantal van "%s" is aangepast naar %d', $item->getName(), $newQuantity));
        return $this->redirectToRoute('item_index');
    }

    // (d) Verwijder een artikel met bevestiging
    #[Route('/artikelen/verwijderen/{id}', name: 'item_delete')]
    public function delete(Request $request, Item $item, ItemService $itemService): Response
    {
        if ($request->isMethod('POST')) {
            $itemService->delete($item);

            $this->addFlash('success', sprintf('Artikel "%s" is verwijderd.', $item->getName()));
            return $this->redirectToRoute('item_index');
        }

        return $this->render('item/confirm_delete.html.twig', [
            'item' => $item,
        ]);
    }
}
