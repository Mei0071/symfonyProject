<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'form.category',
                'constraints' => [new Assert\NotBlank(),]
            ])
            ->add('description', TextType::class,[
                'label' => 'form.description',
                'constraints'=> [new Assert\NotBlank(),]
            ])
            ->add('save',SubmitType::class,[
                'label'=>'form.add',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver):void{
        $resolver->setDefaults([
            'data_class'=>Category::class,
        ]);
    }
}