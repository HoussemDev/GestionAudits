<?php

namespace App\Form;

use App\Entity\Finding;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FindingType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('standard', ChoiceType::class, [
				'label' => 'Standard',
				'choices' => [
					'Qualikita' => 'Qualikita',
					'FAMI-QS' => 'FAMI-QS',
					'FSSC V3' => 'FSSC V3',
				]])
			->add('interpretation', ChoiceType::class, [
				'label' => 'Interpretation',
				'choices' => [
					'Minor' => 'Minor',
					'Major' => 'Major',
					'Critical' => 'Critical',
				]])
			->add('clause', ChoiceType::class, [
				'label' => 'Clause',
				'choices' => [
					'1 - Scope' => '1 - Scope',
					'2 - Normative references' => '2 - Normative references',
					'3 - Terms and definitions' => '3 - Terms and definitions',
					'4 - Generic prerequisite programmes' => '4 - Generic prerequisite programmes',
					'5 - Layout of premises' => '5 - Layout of premises',
				]])
			->add('description', TextareaType::class, [
				'label' => 'Description',
				'attr' => ['class' => 'tinymce'],
			])
			->add('causeanalysis', TextareaType::class, [
				'label' => 'Cause Analysis',
				'attr' => ['class' => 'tinymce'],
			])
			->add('plannedcorrectiveaction', TextareaType::class, [
				'label' => 'Planned Corrective Action',
				'attr' => ['class' => 'tinymce'],
			])
			->add('timescheduleforaction', TextareaType::class, [
				'label' => 'Time Schedule for Action',
				'attr' => ['class' => 'tinymce'],
			])
//			->add('timescheduleforaction', DateType::class, [
//				'label' => 'Initial Certification Date',
//				'placeholder' => [
//					'year' => 'Year', 'month' => 'Month', 'day' => 'Day']
//			])
			->add('status', ChoiceType::class, [
				'label' => 'Status',
				'choices' => [
					'In progress' => 'In progress',
					'Validated' => 'Validated',
				]])
			->add('title');
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Finding::class,
		]);
	}
}
