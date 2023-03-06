<?php

namespace App\Form;

use App\Entity\Exchange;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class ExchangeType extends AbstractType
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            # Add product field who return all the products of the user
            ->add('productId2', EntityType::class, [
                'class' => Product::class,
                'query_builder' => function (ProductRepository $pr) {
                    return $pr->createQueryBuilder('p')
                        ->where('p.user = :user')
                        ->setParameter('user', $this->security->getUser());
                },
                'choice_label' => 'title',
                'label' => 'Product'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            /*'data_class' => Exchange::class,*/
        ]);
    }
}
