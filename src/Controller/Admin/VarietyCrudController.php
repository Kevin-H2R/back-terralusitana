<?php

namespace App\Controller\Admin;

use App\Entity\Variety;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class VarietyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Variety::class;
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
