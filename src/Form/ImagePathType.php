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
                'label' => 'tracking_path.StartMessage',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_path.StartMessage',
                ),
                'translation_domain' => 'ums'))
            ->add('StartImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_path.StartImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_path.StartImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('RanchMessage', null, array(
                'label' => 'tracking_path.RanchMessage',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_path.RanchMessage',
                ),
                'translation_domain' => 'ums'))
            ->add('RanchImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_path.RanchImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_path.RanchImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('FactoryMessage', null, array(
                'required' => false,
                'label' => 'tracking_path.FactoryMessage',
                'attr' => array(
                    'placeholder' => 'tracking_path.FactoryMessage',
                ),
                'translation_domain' => 'ums'))
            ->add('FactoryImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_path.FactoryImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_path.FactoryImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('FactoryDeliveryMessage', null, array(
                'required' => false,
                'label' => 'tracking_path.FactoryDeliveryMessage',
                'attr' => array(
                    'placeholder' => 'tracking_path.FactoryDeliveryMessage',
                ),
                'translation_domain' => 'ums'))
            ->add('FactoryDeliveryImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_path.FactoryDeliveryImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_path.FactoryDeliveryImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('ExportMessage', null, array(
                'required' => false,
                'label' => 'tracking_path.ExportMessage',
                'attr' => array(
                    'placeholder' => 'tracking_path.ExportMessage',
                ),
                'translation_domain' => 'ums'))
            ->add('ExportImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_path.ExportImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_path.ExportImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('ImportMessage', null, array(
                'required' => false,
                'label' => 'tracking_path.ImportMessage',
                'attr' => array(
                    'placeholder' => 'tracking_path.ImportMessage',
                ),
                'translation_domain' => 'ums'))
            ->add('ImportImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_path.ImportImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_path.ImportImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('CenterMessage', null, array(
                'required' => false,
                'label' => 'tracking_path.CenterMessage',
                'attr' => array(
                    'placeholder' => 'tracking_path.CenterMessage',
                ),
                'translation_domain' => 'ums'))
            ->add('CenterImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_path.CenterImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_path.CenterImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('Site1Message', null, array(
                'required' => false,
                'label' => 'tracking_path.Site1Message',
                'attr' => array(
                    'placeholder' => 'tracking_path.Site1Message',
                ),
                'translation_domain' => 'ums'))
            ->add('Site1ImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_path.Site1ImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_path.Site1ImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('Site2Message', null, array(
                'required' => false,
                'label' => 'tracking_path.Site2Message',
                'attr' => array(
                    'placeholder' => 'tracking_path.Site2Message',
                ),
                'translation_domain' => 'ums'))
            ->add('Site2ImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_path.Site2ImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_path.Site2ImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('Site3Message', null, array(
                'required' => false,
                'label' => 'tracking_path.Site3Message',
                'attr' => array(
                    'placeholder' => 'tracking_path.Site3Message',
                ),
                'translation_domain' => 'ums'))
            ->add('Site3ImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_path.Site3ImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_path.Site3ImagePath',
                ),
                'translation_domain' => 'ums'))
            ->add('ClientMessage', null, array(
                'required' => false,
                'label' => 'tracking_path.ClientMessage',
                'attr' => array(
                    'placeholder' => 'tracking_path.ClientMessage',
                ),
                'translation_domain' => 'ums'))
            ->add('ClientImagePath', FileType::class, array(
                'required' => false,
                'label' => 'tracking_path.ClientImagePath',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'tracking_path.ClientImagePath',
                ),
                'translation_domain' => 'ums'));
    }

    public function getName(){
        return 'product';
    }
}