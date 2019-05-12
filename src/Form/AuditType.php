<?php

namespace App\Form;

use App\Entity\Audit;
use App\Entity\Auditor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuditType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('Title')
			->add('Status', ChoiceType::class, [
				'label' => 'Audit Status',
				'choices' => [
					'In progress' => 'In progress' ,
					'Validated certification body' => 'Validated certification body',
				]])
//			->add('Status', EntityType::class, [
//				'class' => Auditor::class,
//				'choice_label' => 'username',
//				])
			->add('Numberfte', NumberType::class, [
				'label' => 'Number of FTE'])
			->add('audittype', ChoiceType::class, [
				'label' => 'Audit Type',
				'choices' => [
					'Certiication Audit Stage 1' => 'Certiication Audit Stage 1' ,
					'Certiication Audit Stage 2' => 'Certiication Audit Stage 2',
					'Surveillance audit' => 'Surveillance audit',
					'Recertification' => 'Recertification',
				]])

			->add('standard', ChoiceType::class, [
				'label' => 'Standard',
				'choices' => [
					'Qualikita' => 'Qualikita',
					'FAMI-QS' => 'FAMI-QS',
					'FSSC V3' => 'FSSC V3',
				]])
			->add('auditdate', DateType::class, [
				'label' => 'Audit Date',
				'placeholder' => [
					'year' => 'Year', 'month' => 'Month', 'day' => 'Day']
			])
			->add('scopestatment', TextareaType::class, [
				'label' => 'Scope Statement',
				'attr' => ['class' => 'tinymce'],
			]);
//			->add('auditdfinding', TextareaType::class, [
//				'label' => 'Audit Finding',
//				'attr' => ['class' => 'tinymce'],
//			]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Audit::class,
		]);
	}
}
