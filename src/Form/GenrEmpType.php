<?php

namespace App\Form;

use App\Entity\GeneralImp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenrEmpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('capabilitymanagementsystem', TextareaType::class, [
				'label' => 'Capability of the management system	',
				'attr' => ['class' => 'tinymce'],
			])
//			->add('titlegeneralimp', TextareaType::class, [
//				'label' => 'Scope Statement',
//				'attr' => ['class' => 'tinymce'],
//			])
			->add('contextorganisation', TextareaType::class, [
				'label' => 'Context of the organisation	',
				'attr' => ['class' => 'tinymce'],
			])
            ->add('leadership', TextareaType::class, [
				'label' => 'Leadership',
				'attr' => ['class' => 'tinymce'],
			])
            ->add('planning', TextareaType::class, [
				'label' => 'Planning',
				'attr' => ['class' => 'tinymce'],
			])
            ->add('support', TextareaType::class, [
				'label' => 'Support',
				'attr' => ['class' => 'tinymce'],
			])
            ->add('operation', TextareaType::class, [
				'label' => 'Operation',
				'attr' => ['class' => 'tinymce'],
			])
            ->add('haccpplancomment', TextareaType::class, [
				'label' => 'HACCP plan comment	',
				'attr' => ['class' => 'tinymce'],
			])
            ->add('haccpplanprocess', ChoiceType::class, [
				'label' => 'HACCP process',
				'choices' => [
					'One' => 'One',
					'Multiple' => 'Multiple',

				]])
            ->add('opportunityimprovement', TextareaType::class, [
				'label' => 'Opportunity for improvement	',
				'attr' => ['class' => 'tinymce'],
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GeneralImp::class,
        ]);
    }
}
