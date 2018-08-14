<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array('translation_domain' => 'ums'))
            ->add('lastname', null, array('translation_domain' => 'ums'))
            ->add('date_birth', BirthdayType::class, array('translation_domain' => 'ums'))
            ->add('sex', ChoiceType::class, array(
                'choices'  => array(
                    ' ' => null,
                    'sex.m' => true,
                    'sex.f' => false,
                ),
                'translation_domain' => 'ums'))
            ->add('id_card', null, array('translation_domain' => 'ums'))
            ->add('phone', null, array('translation_domain' => 'ums'))
            ->add('wechat', null, array('translation_domain' => 'ums'))
            ->add('region', null, array('translation_domain' => 'ums'))
            ->add('address', null, array('translation_domain' => 'ums'))
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()

    {
        return $this->getBlockPrefix();
    }
}
