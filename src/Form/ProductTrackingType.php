<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;


class ProductTrackingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product_id', null, array(

                'label' => 'tracking_page.product_id',
                'attr' => array(
                    'placeholder' => 'tracking_page.product_id',
                ),
                'translation_domain' => 'ums'))
            ->add('production_date', DateTimeType::class, array(
                'label' => 'tracking_page.production_date',
                'attr' => array(
                    'placeholder' => 'tracking_page.production_date',
                ),
                'translation_domain' => 'ums'))
            ->add('batch_id', null, array(
                'required' => false,
                'label' => 'tracking_page.batch_id',
                'attr' => array(
                    'placeholder' => 'tracking_page.batch_id',
                ),
                'translation_domain' => 'ums'))
            ->add('starting_time', DateTimeType::class, array(
                'label' => 'tracking_page.starting_time',
                'attr' => array(
                    'placeholder' => 'tracking_page.starting_time',
                ),
                'translation_domain' => 'ums'))
            ->add('ranch_id', null, array(
                'required' => false,
                'label' => 'tracking_page.ranch_id',
                'attr' => array(
                    'placeholder' => 'tracking_page.ranch_id',
                ),
                'translation_domain' => 'ums'))
            ->add('milk_collection_time', DateTimeType::class, array(
                'label' => 'tracking_page.milk_collection_time',
                'attr' => array(
                    'placeholder' => 'tracking_page.milk_collection_time',
                ),
                'translation_domain' => 'ums'))
            ->add('ranch_responsible', null, array(
                'required' => false,
                'label' => 'tracking_page.ranch_responsible',
                'attr' => array(
                    'placeholder' => 'tracking_page.ranch_responsible',
                ),
                'translation_domain' => 'ums'))
            ->add('factory', null, array(
                'required' => false,
                'label' => 'tracking_page.factory',
                'attr' => array(
                    'placeholder' => 'tracking_page.factory',
                ),
                'translation_domain' => 'ums'))
            ->add('factory_processing_time', DateTimeType::class, array(
                'label' => 'tracking_page.factory_processing_time',
                'attr' => array(
                    'placeholder' => 'tracking_page.factory_processing_time',
                ),
                'translation_domain' => 'ums'))
            ->add('factory_responsible', null, array(
                'required' => false,
                'label' => 'tracking_page.factory_responsible',
                'attr' => array(
                    'placeholder' => 'tracking_page.factory_responsible',
                ),
                'translation_domain' => 'ums'))
            ->add('factory_delivery_time', DateTimeType::class, array(
                'label' => 'tracking_page.factory_delivery_time',
                'attr' => array(
                    'placeholder' => 'tracking_page.factory_delivery_time',
                ),
                'translation_domain' => 'ums'))
            ->add('factory_delivery_responsible', null, array(
                'required' => false,
                'label' => 'tracking_page.factory_delivery_responsible',
                'attr' => array(
                    'placeholder' => 'tracking_page.factory_delivery_responsible',
                ),
                'translation_domain' => 'ums'))
            ->add('export_time', DateTimeType::class, array(
                'label' => 'tracking_page.export_time',
                'attr' => array(
                    'placeholder' => 'tracking_page.export_time',
                ),
                'translation_domain' => 'ums'))
            ->add('export_responsible', null, array(
                'required' => false,
                'label' => 'tracking_page.export_responsible',
                'attr' => array(
                    'placeholder' => 'tracking_page.export_responsible',
                ),
                'translation_domain' => 'ums'))
            ->add('import_time', DateTimeType::class, array(
                'label' => 'tracking_page.import_time',
                'attr' => array(
                    'placeholder' => 'tracking_page.import_time',
                ),
                'translation_domain' => 'ums'))
            ->add('import_responsible', null, array(
                'required' => false,
                'label' => 'tracking_page.import_responsible',
                'attr' => array(
                    'placeholder' => 'tracking_page.import_responsible',
                ),
                'translation_domain' => 'ums'))
            ->add('center_arrival_time', DateTimeType::class, array(
                'label' => 'tracking_page.center_arrival_time',
                'attr' => array(
                    'placeholder' => 'tracking_page.center_arrival_time',
                ),
                'translation_domain' => 'ums'))
            ->add('arrival_responsible', null, array(
                'required' => false,
                'label' => 'tracking_page.arrival_responsible',
                'attr' => array(
                    'placeholder' => 'tracking_page.arrival_responsible',
                ),
                'translation_domain' => 'ums'))
            ->add('site_1', null, array(
                'required' => false,
                'label' => 'tracking_page.site_1',
                'attr' => array(
                    'placeholder' => 'tracking_page.site_1',
                ),
                'translation_domain' => 'ums'))
            ->add('site_1_delivery_time', DateTimeType::class, array(
                'label' => 'tracking_page.site_1_delivery_time',
                'attr' => array(
                    'placeholder' => 'tracking_page.site_1_delivery_time',
                ),
                'translation_domain' => 'ums'))
            ->add('site_1_responsible', null, array(
                'required' => false,
                'label' => 'tracking_page.site_1_responsible',
                'attr' => array(
                    'placeholder' => 'tracking_page.site_1_responsible',
                ),
                'translation_domain' => 'ums'))
            ->add('site_2', null, array(
                'required' => false,
                'label' => 'tracking_page.site_2',
                'attr' => array(
                    'placeholder' => 'tracking_page.site_2',
                ),
                'translation_domain' => 'ums'))
            ->add('site_2_delivery_time', DateTimeType::class, array(

                'label' => 'tracking_page.site_2_delivery_time',
                'attr' => array(
                    'placeholder' => 'tracking_page.site_2_delivery_time',
                ),
                'translation_domain' => 'ums'))
            ->add('site_2_responsible', null, array(
                'required' => false,
                'label' => 'tracking_page.site_2_responsible',
                'attr' => array(
                    'placeholder' => 'tracking_page.site_2_responsible',
                ),
                'translation_domain' => 'ums'))
            ->add('site_3', null, array(
                'required' => false,
                'label' => 'tracking_page.site_3',
                'attr' => array(
                    'placeholder' => 'tracking_page.site_3',
                ),
                'translation_domain' => 'ums'))
            ->add('site_3_delivery_time', DateTimeType::class, array(
                'label' => 'tracking_page.site_3_delivery_time',
                'attr' => array(
                    'placeholder' => 'tracking_page.site_3_delivery_time',
                ),
                'translation_domain' => 'ums'))
            ->add('site_3_responsible', null, array(
                'required' => false,
                'label' => 'tracking_page.site_3_responsible',
                'attr' => array(
                    'placeholder' => 'tracking_page.site_3_responsible',
                ),
                'translation_domain' => 'ums'))
            ->add('client_id', null, array(
                'required' => false,
                'label' => 'tracking_page.client_id',
                'attr' => array(
                    'placeholder' => 'tracking_page.client_id',
                ),
                'translation_domain' => 'ums'))
            ->add('purchase_time', DateTimeType::class, array(
                'label' => 'tracking_page.purchase_time',
                'attr' => array(
                    'placeholder' => 'tracking_page.purchase_time',
                ),
                'translation_domain' => 'ums'))
            ->add('seller_id', null, array(
                'required' => false,
                'label' => 'tracking_page.seller_id',
                'attr' => array(
                    'placeholder' => 'tracking_page.seller_id',
                ),
                'translation_domain' => 'ums'))
        ;
    }

    public function getName(){
        return 'product';
    }
}