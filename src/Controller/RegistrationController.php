<?php
declare(strict_types=1);
namespace App\Controller;

use App\Entity\CustomerInformation;
use App\Entity\User;
use App\Form\UserCustomerInformationType;
use App\Repository\UserRepository;
use App\Service\MailerService;
use App\Service\UserService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class RegistrationController extends AbstractController
{
    public function __construct(protected Environment $twig) {}

    #[Route('/register', name: 'register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserService $userService,
        MailerService $mailerService): Response
    {
        $user = new User();
        $customerInformation = new CustomerInformation();

        $mergeDataType = [
            'customerInformation' => $customerInformation,
            'user' => $user,
        ];

        $form = $this->createForm(UserCustomerInformationType::class, $mergeDataType);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $user->setPassword(
                $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('user')['plainPassword']->getData()
                    )
                );
                $userService->createRegisterUser($user, $customerInformation, $mailerService);
                $this->addFlash("success", "We have sent confirmation of account activation to your email.");
                return $this->redirectToRoute('login');

            }  catch (Exception $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/active-account/{token}', name: 'active_account_token', methods: ['GET|POST'])]
    public function activeAccountToken($token, UserService $userService): RedirectResponse
    {
        try {
            $userService->activeAccount($token);
            $this->addFlash("success", "Account has been activated.");

        } catch (Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
        }

        return $this->redirect($this->generateUrl('login'));
    }
}
