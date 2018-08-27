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
                'label' => 'profile_page.info.firstname',
                'attr' => array(
                    'placeholder' => 'profile_page.info.firstname',
                ),
                'translation_domain' => 'ums'))
            ->add('lastname', null, array(
                'label' => 'profile_page.info.lastname',
                'attr' => array(
                    'placeholder' => 'profile_page.info.lastname',
                ),
                'translation_domain' => 'ums'))
            ->add('date_birth', BirthdayType::class, array(
                'label' => 'profile_page.info.birthday',
                'translation_domain' => 'ums'))
            ->add('phone', null, array(
                'label' => 'profile_page.info.phone',
                'attr' => array(
                    'placeholder' => 'profile_page.info.phone',
                ),
                'translation_domain' => 'ums'))
            ->add('wechat', null, array(
                'label' => 'profile_page.info.wechat',
                'attr' => array(
                    'placeholder' => 'profile_page.info.wechat',
                ),
                'translation_domain' => 'ums'))
            ->add('address', null, array(
                'label' => 'profile_page.info.address',
                'attr' => array(
                    'placeholder' => 'profile_page.info.address',
                ),
                'translation_domain' => 'ums'))
            ->add('region', null, array(
                'label' => 'profile_page.info.region',
                'attr' => array(
                    'placeholder' => 'profile_page.info.region',
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