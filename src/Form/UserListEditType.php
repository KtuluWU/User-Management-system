<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class UserListEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array(
                'label' => 'profile_page.info.username',
                'attr' => array(
                    'placeholder' => 'profile_page.info.username',
                ),
                'translation_domain' => 'ums'))
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
            ->add('sex', ChoiceType::class, array(
                'choices' => [
                    'sex.1' => true,
                    'sex.0' => false
                ],
                'label' => 'profile_page.info.sex',
                'translation_domain' => 'ums'))
            ->add('email', null, array(
                'label' => 'profile_page.info.email',
                'attr' => array(
                    'placeholder' => 'profile_page.info.email',
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
            ->add('enabled', ChoiceType::class, array(
                'choices' => [
                    'enabled.1' => true,
                    'enabled.0' => false
                ],
                'label' => 'userList_pages.enabled',
                'translation_domain' => 'ums'))
        ;
    }

    public function getBlockPrefix()
    {
        return 'app_userList_edit';
    }
}