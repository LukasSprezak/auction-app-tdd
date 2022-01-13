<?php
declare(strict_types=1);
namespace App\Controller;

use App\Entity\ProductOffer;
use App\Form\ProductOfferType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductOfferController extends AbstractController
{
    #[Route('/my-product-offer', name: 'my_product_offer')]
    public function myProductOffer(): Response
    {
        return $this->render('product-offer/my.html.twig');
    }

    #[Route('/add-product-offer', name: 'add_product_offer')]
    public function addProductOffer(Request $request, EntityManagerInterface $entityManager): Response
    {
        $productOffer = new ProductOffer();

        $form = $this->createForm(ProductOfferType::class, $productOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $entityManager->persist($productOffer);
                $entityManager->flush();
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
