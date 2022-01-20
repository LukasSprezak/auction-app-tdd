<?php
declare(strict_types=1);
namespace App\Controller;

use App\Entity\CustomerInformation;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/user/profile', name: 'user_profile', methods: ["GET"])]
    public function userProfile(Request $request): Response
    {
        $id = (int)$request->get('id');
        $userRepository = $this->doctrine->getRepository(User::class);
        $user = $userRepository->find($id);
//        if ($this->getUser() !== $customerInformation->getUserId()) {
//            throw new AccessDeniedException();
//        }

        return $this->render('user/user-profile.html.twig', [
            'user' => $user,
//            'userCustomerInformation' => $customerInformation
        ]);
    }
}