<?php
declare(strict_types=1);
namespace App\Controller;

use App\Form\CustomerInformationType;
use App\Form\UserChangePasswordType;
use App\Form\UserRememberPasswordType;
use App\Repository\CustomerInformationRepository;
use App\Repository\UserRepository;
use App\Service\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Exception;

#[isGranted('ROLE_USER')]
#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/profile', name: 'user_profile', methods: ['GET|POST'])]
    public function userProfile(Request $request, CustomerInformationRepository $customerInformation, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $currentUserAccount = $customerInformation->findOneBy(['userId' => $user]);
        $userLogo = $userRepository->find($user);

        $form = $this->createForm(CustomerInformationType::class, $currentUserAccount);

        if ($request->isMethod("POST")) {
            $form->handleRequest($request);

            try {
                $customerInformation->editCustomerInformation($currentUserAccount);
                $this->addFlash('success', 'Customer information has been updated.');

            } catch (\Exception $exception) {
                $this->addFlash('error', 'Customer information updated error');
            }
        }

        return $this->render('user/user-profile.html.twig', [
            'customerInformationForm' => $form->createView(),
            'userLogo' => $userLogo
        ]);
    }

    #[Route('/change-password', name: 'user_change_password', methods: ['GET|POST'])]
    public function changePassword(
        Request $request,
        UserPasswordHasherInterface $hasher,
        UserInterface $user,
        UserService $userService): Response
    {
        $changePasswordForm = $this->createForm(UserChangePasswordType::class, $user);

        if ($request->isMethod('POST')) {
            $changePasswordForm->handleRequest($request);

            if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
                try {
                    $userService->changePassword($user, $hasher);
                    $this->addFlash('success', 'Your password has been changed');

                } catch (Exception $exception) {
                    $this->addFlash('error', $exception->getMessage());
                }
            }
        }

        return $this->render('user/change-password.html.twig', [
            'changePasswordForm' => $changePasswordForm->createView(),
        ]);
    }

    #[Route('/remember-password', name: 'user_remember_password', methods: ['GET|POST'])]
    public function rememberPassword(Request $request, UserService $userService): RedirectResponse|Response
    {
        $rememberPasswordForm = $this->createForm(UserRememberPasswordType::class);

        if ($request->isMethod('POST')) {
            $rememberPasswordForm->handleRequest($request);

            if ($rememberPasswordForm->isValid()) {
                try {

                    $email = $rememberPasswordForm->get('email')->getData();
                    $userService->sendLinkToNewPassword($email);
                    $this->addFlash("success", 'Password change information has been sent to your email.');

                    return $this->redirect($this->generateUrl('login'));

                } catch (Exception $exception) {
                    $formError = new FormError($exception->getMessage());
                    $rememberPasswordForm->get('email')->addError($formError);
                }
            }
        }

        return $this->render('user/remember-password.html.twig', [
            'rememberPasswordForm' => $rememberPasswordForm->createView(),
        ]);
    }

    #[Route('/notifications', name: 'user_notifications', methods: ['GET|POST'])]
    public function notifications(Request $request): Response
    {
        return $this->render('user/notifications.html.twig');
    }
}