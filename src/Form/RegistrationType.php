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
            ->add('firstname', null, array('translation_domain' => 'ums'))
            ->add('lastname', null, array('translation_domain' => 'ums'))
            ->add('username', null, array('translation_domain' => 'ums'))
            ->add('email', EmailType::class, array('translation_domain' => 'ums'))
            ->add('plainPassword', PasswordType::class, array('translation_domain' => 'ums'))
            ->add('date_birth', BirthdayType::class, array('translation_domain' => 'ums'))
            ->add('sex', ChoiceType::class, array(
                'choices'  => array(
                    'sex.m' => 1,
                    'sex.f' => 0,
                ),
                'translation_domain' => 'ums'))
            ->add('id_card', null, array('translation_domain' => 'ums'))
            ->add('phone', null, array('translation_domain' => 'ums'))
            ->add('wechat', null, array('translation_domain' => 'ums'))
            ->add('region', null, array('translation_domain' => 'ums'))
            ->add('address', null, array('translation_domain' => 'ums'))
        ;
    }
}
