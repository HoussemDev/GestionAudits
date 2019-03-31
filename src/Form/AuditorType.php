<?php

namespace App\Form;

use App\Entity\Auditor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuditorType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('firstname', TextType::class, [
				'label' => 'First Name'
			])
			->add('lastname', TextType::class, [
				'label' => 'Last Name'
			])
			->add('username', TextType::class, [
				'label' => 'User Name'
			])
//            ->add('password', RepeatedType::class,[
//				'type' => PasswordType::class,
//				'first_options' => ['label' => 'Password'],
//				'second_options' =>['label' => 'Repeated password']
//			])
			->add('password', PasswordType::class, [
				'label' => 'Password'
			])
			->add('gender', ChoiceType::class, [
				'label' => 'Gender',
				'choices' => [
					'Male' => 1,
					'Female' => 2,

				]])
			->add('email', EmailType::class, [
				'label' => 'Email'
			]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Auditor::class,
		]);
	}
}
