<?php
declare(strict_types=1);
namespace App\Controller;

use App\Repository\ProductOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdvertisementController extends AbstractController
{
    #[Route('/', name: 'advertisement_index', defaults: ['page' => '1'], methods: ['GET']),
        Route('/page/{page<[1-9]\d*>}', name: 'advertisement_index_paginated', methods: ['GET']),
    ]
    public function index(int $page, ProductOfferRepository $allProductOffersRepository): Response
    {
        $allProductOffers = $allProductOffersRepository->getAllProductOffersPaginator($page);

        return $this->render('home/index.html.twig', [
            'paginator' => $allProductOffers,
        ]);
    }
}
