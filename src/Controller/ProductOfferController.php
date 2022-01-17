<?php
declare(strict_types=1);
namespace App\Controller;

use App\Entity\ProductOffer;
use App\Form\ProductOfferType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class ProductOfferController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/my-product-offer', name: 'my_product_offer', methods: ["GET"] )]
    public function myProductOffer(): Response
    {
        $entityManager = $this->doctrine;
        $productOffers = $entityManager
            ->getRepository(ProductOffer::class)
            ->getPublicProductOffers();

        return $this->render('product-offer/my.html.twig', [
            'productOffers' => $productOffers,
        ]);
    }

    #[Route('/add-product-offer', name: 'add_product_offer', methods: ["GET|POST"])]
    public function addProductOffer(Request $request): Response
    {
        $productOffer = new ProductOffer();
        $productOfferRepository = $this->doctrine->getRepository(ProductOffer::class);

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

        return $this->render('product-offer/add.html.twig', [
            'productOfferForm' => $form->createView()
        ]);
    }
}
