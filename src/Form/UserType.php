<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
				'label' => 'First Name'
			])
			->add('lastname', TextType::class, [
				'label' => 'Last Name'
			])
            ->add('email', EmailType::class, [
				'label' => 'Email'
			])
            ->add('username', TextType::class, [
				'label' => 'User Name'
			])
            ->add('passwword', PasswordType::class, [
				'label' => 'Password'
			])
//            ->add('roles')
			->add('gender', ChoiceType::class, [
				'label' => 'Gender',
				'choices' => [
					'Male' => 'Male',
					'Female' => 'Female',

				]])
//			->add('roles', ChoiceType::class, [
//				'label' => 'Roles',
//				'choices' => [
//
//					'choices' => array('ROLE_CBADMIN' => 'Admin', 'ROLE_AUDITOR' => 'Auditor'),
//					'multiple' => false,
//
//				]])
//
//			->add('roles', ChoiceType::class, array(
//				'multiple' => false,
//
//				'choices' => array('ROLE_CBADMIN' => 'Admin'),
//				 'choices' => array('ROLE_AUDITOR' => 'Auditor'),
//			));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
