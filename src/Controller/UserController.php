<?php
declare(strict_types=1);
namespace App\Controller;

use App\Form\CustomerInformationType;
use App\Repository\CustomerInformationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/profile', name: 'user_profile', methods: ['GET|POST'])]
    public function userProfile(Request $request, CustomerInformationRepository $customerInformation): Response
    {
        $user = $this->getUser();
        $currentUserAccount = $customerInformation->findOneBy(['userId' => $user]);

        $form = $this->createForm(CustomerInformationType::class, $currentUserAccount);

        if ($request->isMethod("POST")) {
            $form->handleRequest($request);

            try {
                $customerInformation->editCustomerInformation($currentUserAccount);
                $this->addFlash("success", "Customer information has been updated");

            } catch (\Exception $exception) {
                $this->addFlash('error', 'Customer information updated error');
            }
        }

        return $this->render('user/user-profile.html.twig', [
            'customerInformationForm' => $form->createView(),
        ]);
    }

    #[Route('/user/change-password', name: 'user_change_password', methods: ['GET|POST'])]
    public function changePassword(Request $request): Response
    {
        return $this->render('user/security-profile.html.twig');
    }

    #[Route('/user/notifications', name: 'user_notifications', methods: ['GET|POST'])]
    public function notifications(Request $request): Response
    {
        return $this->render('user/notifications.html.twig');
    }
}