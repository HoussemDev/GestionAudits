<?php

namespace App\Form;

use App\Entity\CB;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CbType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('number', NumberType::class, [
				'label' => 'Certification Body Number'])
			->add('name', TextType::class, [
				'label' => 'Certification Body Name'
			])
			->add('adress', TextareaType::class, [
				'label' => 'Certification Body  adress',
				'attr' => ['class' => 'tinymce'],
			])
			->add('city')
			->add('country', CountryType::class)
			->add('website', UrlType::class)
			->add('contactperson', TextareaType::class, [
				'label' => 'Contact person for Certification Body',
				'attr' => ['class' => 'tinymce'],
			]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => CB::class,
		]);
	}
}
