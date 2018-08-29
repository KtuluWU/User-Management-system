<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array(
                'label' => 'user_infos.firstname',
                'attr' => array(
                    'placeholder' => 'user_infos.firstname',
                ),
                'translation_domain' => 'ums'))
            ->add('lastname', null, array(
                'label' => 'user_infos.lastname',
                'attr' => array(
                    'placeholder' => 'user_infos.lastname',
                ),
                'translation_domain' => 'ums'))
            ->add('date_birth', BirthdayType::class, array(
                'label' => 'user_infos.date_birth',
                'translation_domain' => 'ums'))
            ->add('phone', null, array(
                'label' => 'user_infos.phone',
                'attr' => array(
                    'placeholder' => 'user_infos.phone',
                ),
                'translation_domain' => 'ums'))
            ->add('wechat', null, array(
                'label' => 'user_infos.wechat',
                'attr' => array(
                    'placeholder' => 'user_infos.wechat',
                ),
                'translation_domain' => 'ums'))
            ->add('address', null, array(
                'label' => 'user_infos.address',
                'attr' => array(
                    'placeholder' => 'user_infos.address',
                ),
                'translation_domain' => 'ums'))
            ->add('region', null, array(
                'label' => 'user_infos.region',
                'attr' => array(
                    'placeholder' => 'user_infos.region',
                ),
                'translation_domain' => 'ums'))
            ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }
}