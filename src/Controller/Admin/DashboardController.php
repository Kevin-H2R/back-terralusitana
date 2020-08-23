<?php

namespace App\Controller\Admin;

use App\Entity\Region;
use App\Entity\Trophy;
use App\Entity\Variety;
use App\Entity\Wine;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package App\Controller\Admin
 * @IsGranted("ROLE_ADMIN")
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Terralusitana');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Region', 'fa fa-map', Region::class);
        yield MenuItem::linkToCrud('Trophy', 'fa fa-medal', Trophy::class);
        yield MenuItem::linkToCrud('Variety', 'fa fa-seedling', Variety::class);
        yield MenuItem::linkToCrud('Wine', 'fa fa-wine-glass-alt', Wine::class);
    }
}
