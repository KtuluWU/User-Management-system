<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product_id', null, array(
                'attr' => array(
                    'placeholder' => 'product_page.product_id',
                ),
                'translation_domain' => 'ums'))
            ->add('product_name', null, array(
                'attr' => array(
                    'placeholder' => 'product_page.product_name',
                ),
                'translation_domain' => 'ums'))
            ->add('barcode', null, array(
                'attr' => array(
                    'placeholder' => 'product_page.barcode',
                ),
                'translation_domain' => 'ums'))
            ->add('image_path', null, array(
                'attr' => array(
                    'placeholder' => 'product_page.image_path',
                ),
                'translation_domain' => 'ums'))
            ->add('category', null, array(
                'attr' => array(
                    'placeholder' => 'product_page.category',
                ),
                'translation_domain' => 'ums'))
            ->add('shelf_life', null, array(
                'attr' => array(
                    'placeholder' => 'product_page.shelf_life',
                ),
                'translation_domain' => 'ums'))
            ->add('promotion', null, array(
                'attr' => array(
                    'placeholder' => 'product_page.promotion',
                ),
                'translation_domain' => 'ums'))
            ->add('stock', NumberType::class, array(
                'attr' => array(
                    'placeholder' => 'product_page.stock',
                ),
                'translation_domain' => 'ums'))
            ->add('description', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'product_page.description',
                ),
                'translation_domain' => 'ums'));
    }

    public function getName(){
        return 'product';
    }
}