<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array(
                'attr' => array(
                    'placeholder' => 'registration_page.firstname',
                ),
                'translation_domain' => 'ums'))
            ->add('lastname', null, array(
                'attr' => array(
                    'placeholder' => 'registration_page.lastname',
                ),
                'translation_domain' => 'ums'))
            ->add('username', null, array(
                'attr' => array(
                    'placeholder' => 'registration_page.username',
                ),
                'translation_domain' => 'ums'))
            ->add('email', EmailType::class, array(
                'attr' => array(
                    'placeholder' => 'registration_page.email',
                ),
                'translation_domain' => 'ums'))
            ->add('plainPassword', PasswordType::class, array(
                'attr' => array(
                    'placeholder' => 'registration_page.password',
                ),
                'translation_domain' => 'ums'))
            ->add('date_birth', BirthdayType::class, array(
                'label' => 'registration_page.date_birth',
                'translation_domain' => 'ums'))
            ->add('sex', ChoiceType::class, array(
                'label' => 'registration_page.sex.title',
                'choices'  => array(
                    'registration_page.sex.m' => true,
                    'registration_page.sex.f' => false,
                ),
                'translation_domain' => 'ums'))
            ->add('id_card', null, array(
                'attr' => array(
                    'placeholder' => 'registration_page.id_card',
                ),
                'translation_domain' => 'ums'))
            ->add('phone', null, array(
                'attr' => array(
                    'placeholder' => 'registration_page.phone',
                ),
                'translation_domain' => 'ums'))
            ->add('wechat', null, array(
                'attr' => array(
                    'placeholder' => 'registration_page.wechat',
                ),
                'translation_domain' => 'ums'))
            ->add('region', ChoiceType::class, array(
                'choices' => [
                    'region.beijing' => 'beijing',
                    'region.shanghai' => 'shanghai',
                    'region.tianjin' => 'tianjin',
                    'region.jiangsu' => 'jiangsu',
                    'region.hainan' => 'hainan',
                    'region.taiwan' => 'taiwan'
                ],
                'label' => 'user_infos.region',
                'attr' => array(
                    'placeholder' => 'user_infos.region',
                ),
                'translation_domain' => 'ums'))
            ->add('address', null, array(
                'attr' => array(
                    'placeholder' => 'registration_page.address',
                ),
                'translation_domain' => 'ums'))
        ;
    }
}
