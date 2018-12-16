<?php

namespace App\Form;

use function Sodium\add;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class PurchaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user_id', null, array(
                'required' => false,
                'label' => 'purchase_page.user_id',
                'attr' => array(
                    'placeholder' => 'purchase_page.user_id',
                ),
                'translation_domain' => 'ums'))
            ->add('product_id', null, array(
                'label' => 'purchase_page.product_id',
                'attr' => array(
                    'placeholder' => 'purchase_page.product_id',
                ),
                'translation_domain' => 'ums'))
            ->add('tracking_id',null, array(
                'label' => 'purchase_page.tracking_id',
                'attr' => array(
                    'placeholder' => 'purchase_page.tracking_id',
                ),
                'translation_domain' => 'ums'))
            ->add('purchase_time', DateTimeType::class, array(
                'label' => 'purchase_page.purchase_time',
                'attr' => array(
                    'placeholder' => 'purchase_page.purchase_time',
                ),
                'translation_domain' => 'ums'))
            ->add('seller_id', null, array(
                'required' => false,
                'label' => 'purchase_page.seller_id',
                'attr' => array(
                    'placeholder' => 'purchase_page.seller_id',
                ),
                'translation_domain' => 'ums'))
            ->add('purchase_id', HiddenType::class);

    }
}