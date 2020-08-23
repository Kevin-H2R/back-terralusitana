<?php

namespace App\Controller\Admin;

use App\Entity\Trophy;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TrophyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Trophy::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
