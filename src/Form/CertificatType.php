<?php

namespace App\Form;

use App\Entity\Certificat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CertificatType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('title')
			->add('scopestatment', TextareaType::class, [
				'label' => 'Scope Statement',
				'attr' => ['class' => 'tinymce'],
			])
			->add('Certificatstatus', ChoiceType::class, [
				'label' => 'Certificat Status',
				'choices' => [
					'Valid' => 'Valid',
					'Suspended' => 'Suspended',
					'Withdrawn' => 'Withdrawn',
					'Cancelled' => 'Cancelled',
					'Transferred' => 'Transferred',
				]])
			->add('issuedate', DateType::class, [
				'label' => 'Issue Date',
				'placeholder' => [
					'year' => 'Year', 'month' => 'Month', 'day' => 'Day']
			])
			->add('validuntil', DateType::class, [
				'label' => 'Valid Until',
				'placeholder' => [
					'year' => 'Year', 'month' => 'Month', 'day' => 'Day']
			])
			->add('initialcertdate', DateType::class, [
				'label' => 'Initial Certification Date',
				'placeholder' => [
					'year' => 'Year', 'month' => 'Month', 'day' => 'Day']
			])
			->add('scope');
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Certificat::class,
		]);
	}
}
