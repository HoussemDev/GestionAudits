<?php

namespace App\Form;

use App\Entity\OrganisationSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganisationSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
				'required' => false,
				'label' => false,
				'attr' => [
					'placeholder' => 'Organisation name'
				]
			])
//            ->add('cbname', TextType::class,[
//				'required' => false,
//				'label' => false,
//				'attr' => [
//					'placeholder' => 'Certification Body name'
//				]
//			])
            ->add('country', TextType::class,[
				'required' => false,
				'label' => false,
				'attr' => [
					'placeholder' => 'Country'
				]
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrganisationSearch::class,
			'method'=>'get',
			'csrf_protection' => false
        ]);
    }
}
