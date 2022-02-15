<?php
declare(strict_types=1);
namespace App\Controller;

use App\Form\CustomerInformationType;
use App\Form\UserChangePasswordType;
use App\Repository\CustomerInformationRepository;
use App\Service\UserService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
    public function changePassword(Request $request, UserPasswordHasherInterface $hasher, UserInterface $user, UserService $userService): Response
    {
        $changePasswordForm = $this->createForm(UserChangePasswordType::class, $user);
        $changePasswordForm->handleRequest($request);

        if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
            try {
                $userService->changePassword($user, $hasher);
                $this->addFlash("success", "Your password has been changed");

            } catch (Exception $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('user/change-password.html.twig', [
            'changePasswordForm' => $changePasswordForm->createView(),
        ]);
    }

    #[Route('/user/notifications', name: 'user_notifications', methods: ['GET|POST'])]
    public function notifications(Request $request): Response
    {
        return $this->render('user/notifications.html.twig');
    }
}