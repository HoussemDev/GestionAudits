<?php

namespace App\Form;

use App\Entity\Organisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganisationType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('number', NumberType::class, [
				'label' => 'Organisation Number'])
			->add('name', TextType::class,[
				'label' => 'Organisation Name'
			])
			->add('adress', TextareaType::class, [
				'label' => 'Organisation adress',
				'attr' => ['class' => 'tinymce'],
			])
			->add('city')
			->add('country', CountryType::class)
			->add('website', UrlType::class)
			->add('contactperson', TextareaType::class, [
				'label' => 'Contact person for the Organosation',
				'attr' => ['class' => 'tinymce'],
			]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Organisation::class,
		]);
	}
}
