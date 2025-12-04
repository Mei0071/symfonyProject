<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Enum\StatusProduct;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ProductType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'form.name',
                'constraints'=> [new Assert\NotBlank(),]
            ])
            ->add('price',MoneyType::class,[
                'label' => 'form.price',
                'constraints'=>[new Assert\NotBlank(), new Assert\Positive(),]
            ])
            ->add('description', TextType::class,[
                'label' => 'form.description',
                'constraints'=> [new Assert\NotBlank(),]
            ])
            ->add('stock', NumberType::class, [
                'label' => 'form.stock',
                'constraints'=> [new Assert\NotBlank(), new Assert\PositiveOrZero(),]
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'form.status',
                'choices' => StatusProduct::cases(),
                'choice_label'=>fn(StatusProduct $s)=>$s->value,
                'choice_value'=>fn(?StatusProduct $s) => $s?->value,
                'constraints'=> [new Assert\NotBlank(),]
            ])
            ->add('category', EntityType::class, [
                'label'=>'form.category',
                'class'=>Category::class,
                'choice_label'=>'name',
                'placeholder'=>'form.placeHolderCategory',
            ])
            ->add('save',SubmitType::class,[
                'label'=>'form.add',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver):void{
        $resolver->setDefaults([
            'data_class'=>Product::class,
        ]);
    }
}