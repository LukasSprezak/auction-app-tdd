<?php
declare(strict_types=1);
namespace App\Controller;

use App\Entity\ProductOffer;
use App\Enum\StatusProductOfferEnum;
use App\Form\ProductOfferType;
use App\Repository\ProductOfferRepository;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

class ProductOfferController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/my-product-offer', name: 'my_product_offer', defaults: ['page' => '1'], methods: ['GET']),
      Route('/my-product-offer/page/{page<[1-9]\d*>}', name: 'my_product_offer_paginated', methods: ['GET']),
    ]
    public function myProductOffer(int $page, ProductOfferRepository $productOfferRepository): Response
    {
        $allCurrentUserProductOffers = $productOfferRepository->getProductOffersPaginator($page);

        return $this->render('product-offer/my.html.twig', [
            'paginator' => $allCurrentUserProductOffers,
        ]);
    }

    #[Route('/add-product-offer', name: 'add_product_offer', methods: ['GET','POST'] )]
    public function addProductOffer(Request $request, MailerService $mailerService, UserInterface $user): Response
    {
        $productOffer = new ProductOffer();
        $productOfferRepository = $this->doctrine
            ->getRepository(ProductOffer::class);

        $form = $this->createForm(ProductOfferType::class, $productOffer);
        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
            try {
                $productOfferRepository->createProductOffer($productOffer);

                $this->addFlash('success', 'Product offer add success');
                return $this->redirectToRoute('my_product_offer');

            } catch (\Exception $exception) {
                $this->addFlash('error', 'Product offer add error');
            }
        }
        $mailerService->sendAddProductOffer($user);
        return $this->render('product-offer/add.html.twig', [
            'productOfferForm' => $form->createView()
        ]);
    }

    #[Route('/my-product-offer/{id}', name: 'view_product_offer')]
    public function viewProductOffer(ProductOffer $productOffer): Response
    {
        if ($productOffer->getStatus() === StatusProductOfferEnum::FINISHED) {
            return $this->render("product-offer/finished.html.twig", [
                "productOffer" => $productOffer
            ]);
        }

        return $this->render('product-offer/view.html.twig', [
            'productOffer' => $productOffer
        ]);
    }

    #[Route('/my-product-offer/edit/{id}', name: 'edit_product_offer', methods: ['GET','POST'])]
    public function editProductOffer(Request $request, ProductOffer $productOffer): Response
    {
        $productOfferRepository = $this->doctrine
            ->getRepository(ProductOffer::class);

        $form = $this->createForm(ProductOfferType::class, $productOffer);

        if ($request->isMethod("POST")) {
            $form->handleRequest($request);

            try {
                $productOfferRepository->createProductOffer($productOffer);

                $this->addFlash("success", "Offer {$productOffer->getTitle()} has been updated");
                return $this->redirectToRoute("view_product_offer", [
                    "id" => $productOffer->getId()
                ]);

            } catch (\Exception $exception) {
                $this->addFlash('error', 'Product offer updated error');
            }
        }

        return $this->render("product-offer/edit.html.twig", [
            "productOfferForm" => $form->createView()
        ]);
    }

    #[Route('/my-product-offer/delete/{id}', name: 'delete_product_offer', methods: ['GET'])]
    public function deleteProductOffer(ProductOffer $productOffer): Response
    {
        $productOfferRepository = $this->doctrine
            ->getRepository(ProductOffer::class);

        try {
            $productOfferRepository->deleteProductOffer($productOffer);
            $this->addFlash("success", "Offer {$productOffer->getTitle()} has been delete");

        } catch (\Exception $exception) {
            $this->addFlash('error', 'Product offer deleted error');
        }

        return $this->redirectToRoute('my_product_offer');
    }
}
