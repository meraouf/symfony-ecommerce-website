<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;


class OrderCrudController extends AbstractCrudController
{
    private $entityManager;
    private $crudUrlGenerator;

    public function __construct(EntityManagerInterface $em, AdminUrlGenerator $cug) {
        $this->entityManager = $em;
        $this->crudUrlGenerator = $cug;
    }

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $updatePreparation = Action::new('updatePreparation', 'Preparation en cours')
            ->linkToCrudAction('updatePreparation');
        return $actions
           ->add('detail', $updatePreparation) 
           ->add('index', 'detail');
    }

    public function updatePreparation(AdminContext $context) {
        $order = $context->getEntity()->getInstance();
        $order->setStatus(1);
        $this->entityManager->flush();
        
        $url  = $this->crudUrlGenerator
            ->setController(OrderCrudController::Class)
            ->setAction('index')
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateField::new('createdAt', 'Passé le'),
            TextField::new('user.getFullName','prénom Nom'),
            MoneyField::new('total')->setCurrency('DZD'),
            BooleanField::new('isPaid', 'Payée'),
            ChoiceField::new('status')->setChoices([
                'Validé' => 0,
                'Préparation en cours' => 1,
                'Livrison' => 2
            ])
        ];
    }

}
