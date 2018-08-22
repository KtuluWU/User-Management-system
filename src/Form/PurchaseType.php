<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class PurchaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user_id', null, array(
                'attr' => array(
                    'placeholder' => 'purchase_page.user_id',
                ),
                'translation_domain' => 'ums'))
            ->add('product_id', null, array(
                'attr' => array(
                    'placeholder' => 'purchase_page.product_id',
                ),
                'translation_domain' => 'ums')) 
            ->add('date_purchase',DateType::class,array(
                'label' => 'purchase_page.date_purchase',
                'translation_domain' => 'ums'))
            ->add('purchase_tracking_id',null, array(
                'attr' => array(
                    'placeholder' => 'purchase_page.purchase_tracking_id',
                ),
                'translation_domain' => 'ums'))
            ->add('quantity',NumberType::class, array(
                'attr' => array(
                    'placeholder' => 'purchase_page.quantity',
                ),
                'translation_domain' => 'ums'));
    }
}