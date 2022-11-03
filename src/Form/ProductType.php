<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ## Add imageFile field
            ->add('imageFile', VichImageType::class, [
                'label' => "Image (JPG or PNG file)",
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Delete image',
                'download_uri' => false,
                'imagine_pattern' => 'squared_thumbnail_small'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
