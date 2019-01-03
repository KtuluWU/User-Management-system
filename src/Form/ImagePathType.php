<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ImagePathType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('StartMessage', null, array(
                'label' => 'tracking_page.StartMessage',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_page.StartMessage',
                ),
                'translation_domain' => 'ums'))
            ->add('StartImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_page.StartImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_page.StartImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('RanchMessage', null, array(
                'label' => 'tracking_page.RanchMessage',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_page.RanchMessage',
                ),
                'translation_domain' => 'ums'))
            ->add('RanchImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_page.RanchImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_page.RanchImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('FactoryMessage', null, array(
                'required' => false,
                'label' => 'tracking_page.FactoryMessage',
                'attr' => array(
                    'placeholder' => 'tracking_page.FactoryMessage',
                ),
                'translation_domain' => 'ums'))
            ->add('FactoryImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_page.FactoryImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_page.FactoryImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('FactoryDeliveryMessage', null, array(
                'required' => false,
                'label' => 'tracking_page.FactoryDeliveryMessage',
                'attr' => array(
                    'placeholder' => 'tracking_page.FactoryDeliveryMessage',
                ),
                'translation_domain' => 'ums'))
            ->add('FactoryDeliveryImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_page.FactoryDeliveryImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_page.FactoryDeliveryImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('ExportMessage', null, array(
                'required' => false,
                'label' => 'tracking_page.ExportMessage',
                'attr' => array(
                    'placeholder' => 'tracking_page.ExportMessage',
                ),
                'translation_domain' => 'ums'))
            ->add('ExportImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_page.ExportImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_page.ExportImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('ImportMessage', null, array(
                'required' => false,
                'label' => 'tracking_page.ImportMessage',
                'attr' => array(
                    'placeholder' => 'tracking_page.ImportMessage',
                ),
                'translation_domain' => 'ums'))
            ->add('ImportImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_page.ImportImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_page.ImportImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('CenterMessage', null, array(
                'required' => false,
                'label' => 'tracking_page.CenterMessage',
                'attr' => array(
                    'placeholder' => 'tracking_page.CenterMessage',
                ),
                'translation_domain' => 'ums'))
            ->add('CenterImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_page.CenterImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_page.CenterImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('Site1Message', null, array(
                'required' => false,
                'label' => 'tracking_page.Site1Message',
                'attr' => array(
                    'placeholder' => 'tracking_page.Site1Message',
                ),
                'translation_domain' => 'ums'))
            ->add('Site1ImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_page.Site1ImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_page.Site1ImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('Site2Message', null, array(
                'required' => false,
                'label' => 'tracking_page.Site2Message',
                'attr' => array(
                    'placeholder' => 'tracking_page.Site2Message',
                ),
                'translation_domain' => 'ums'))
            ->add('Site2ImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_page.Site2ImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_page.Site2ImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('Site3Message', null, array(
                'required' => false,
                'label' => 'tracking_page.Site3Message',
                'attr' => array(
                    'placeholder' => 'tracking_page.Site3Message',
                ),
                'translation_domain' => 'ums'))
            ->add('Site3ImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_page.Site3ImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_page.Site3ImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('ClientMessage', null, array(
                'required' => false,
                'label' => 'tracking_page.ClientMessage',
                'attr' => array(
                    'placeholder' => 'tracking_page.ClientMessage',
                ),
                'translation_domain' => 'ums'))
            ->add('ClientImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_page.ClientImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_page.ClientImagePath',
                ),
                'translation_domain' => 'ums'));
    }

    public function getName(){
        return 'product';
    }
}