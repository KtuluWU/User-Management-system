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
                    'region.11' => '11',
                    'region.12' => '12',
                    'region.13' => '13',
                    'region.14' => '14',
                    'region.15' => '15',
                    'region.21' => '21',
                    'region.22' => '22',
                    'region.23' => '23',
                    'region.31' => '31',
                    'region.32' => '32',
                    'region.33' => '33',
                    'region.34' => '34',
                    'region.35' => '35',
                    'region.36' => '36',
                    'region.37' => '37',
                    'region.41' => '41',
                    'region.42' => '42',
                    'region.43' => '43',
                    'region.44' => '44',
                    'region.45' => '45',
                    'region.46' => '46',
                    'region.50' => '50',
                    'region.51' => '51',
                    'region.52' => '52',
                    'region.53' => '53',
                    'region.54' => '54',
                    'region.61' => '61',
                    'region.62' => '62',
                    'region.63' => '63',
                    'region.64' => '64',
                    'region.65' => '65',
                    'region.81' => '81',
                    'region.82' => '82',
                    'region.71' => '71',
                    'region.99' => '99'
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
