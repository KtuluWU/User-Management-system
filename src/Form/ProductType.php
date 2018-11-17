<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product_name', null, array(
                'label' => 'product_page.product_name',
                'attr' => array(
                    'placeholder' => 'product_page.product_name',
                ),
                'translation_domain' => 'ums'))
            ->add('barcode', null, array(
                'label' => 'product_page.barcode',
                'attr' => array(
                    'placeholder' => 'product_page.barcode',
                ),
                'translation_domain' => 'ums'))
            ->add('image_path', FileType::class, array(
                'required' => false,
                'label' => 'product_page.image_path',
                'attr' => array(
                    'placeholder' => 'product_page.image_path',
                ),
                'translation_domain' => 'ums'))
            ->add('category', null, array(
                'label' => 'product_page.category',
                'attr' => array(
                    'placeholder' => 'product_page.category',
                ),
                'translation_domain' => 'ums'))
            ->add('shelf_life', null, array(
                'label' => 'product_page.shelf_life',
                'attr' => array(
                    'placeholder' => 'product_page.shelf_life',
                ),
                'translation_domain' => 'ums'))
            ->add('promotion', null, array(
                'label' => 'product_page.promotion',
                'attr' => array(
                    'placeholder' => 'product_page.promotion',
                ),
                'translation_domain' => 'ums'))
            ->add('stock', NumberType::class, array(
                'label' => 'product_page.stock',
                'attr' => array(
                    'placeholder' => 'product_page.stock',
                ),
                'translation_domain' => 'ums'))
            ->add('description', TextType::class, array(
                'label' => 'product_page.description',
                'attr' => array(
                    'placeholder' => 'product_page.description',
                ),
                'translation_domain' => 'ums'));
    }

    public function getName(){
        return 'product';
    }
}