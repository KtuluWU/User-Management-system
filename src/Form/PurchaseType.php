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
            ->add('user_phone', null, array(
                'label' => 'purchase_page.phone',
                'attr' => array(
                    'placeholder' => 'purchase_page.phone',
                ),
                'translation_domain' => 'ums'))
            ->add('product_id', null, array(
                'label' => 'purchase_page.product_id',
                'attr' => array(
                    'placeholder' => 'purchase_page.product_id',
                ),
                'translation_domain' => 'ums')) 
            ->add('date_purchase',DateTimeType::class,array(
                'label' => 'purchase_page.date_purchase',
                'translation_domain' => 'ums'))
            ->add('purchase_tracking_id',null, array(
                'label' => 'purchase_page.purchase_tracking_id',
                'attr' => array(
                    'placeholder' => 'purchase_page.purchase_tracking_id',
                ),
                'translation_domain' => 'ums'))
            ->add('quantity',NumberType::class, array(
                'label' => 'purchase_page.quantity',
                'attr' => array(
                    'placeholder' => 'purchase_page.quantity',
                ),
                'translation_domain' => 'ums'))
            ->add('purchase_id', HiddenType::class);
    }
}