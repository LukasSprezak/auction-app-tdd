<?php
declare(strict_types=1);
namespace App\Controller\Admin;

use App\Entity\ProductOffer;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[isGranted('ROLE_ADMIN')]
class AdminController extends AbstractDashboardController
{
    private const DIRECTORY_LOGO = '/upload/logo/';

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Auction Admin Panel');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        if (!$user instanceof User) {
            throw new \Exception('Failed user');
        }

        return parent::configureUserMenu($user)
            ->setAvatarUrl(self::DIRECTORY_LOGO . $user->getLogo())
            ->setMenuItems([
                MenuItem::linkToUrl('Profile', 'fas fa-user', $this->generateUrl('user_profile'))
            ])
        ;
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToCrud('Users', 'fas fa-user', User::class),
            MenuItem::linkToCrud('All Products', 'fas fa-store', ProductOffer::class),
            MenuItem::linkToUrl('Homepage', 'fa fa-globe', $this->generateUrl('advertisement_index'))
        ];
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
        ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
