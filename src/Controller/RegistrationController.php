<?php
declare(strict_types=1);
namespace App\Controller;

use App\Entity\CustomerInformation;
use App\Entity\User;
use App\Form\UserCustomerInformationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager): Response
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

            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('user')['plainPassword']->getData()
                )
            );

            if (!is_null($user)) {
                $customerInformation->setUserId($user);
            }

            $entityManager->persist($user);
            $entityManager->persist($customerInformation);
            $entityManager->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
