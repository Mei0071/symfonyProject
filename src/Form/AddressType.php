<?php
namespace App\Form;

use App\Entity\Address;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('street', TextType::class, [
                'label' => 'Rue',
                'constraints' => [new Assert\NotBlank()],
            ])
            ->add('postalCode', IntegerType::class, [
                'label' => 'Code postal',
                'constraints' => [new Assert\NotBlank(),new Assert\Positive(message: 'Le code postal doit être un nombre positif.'),],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'constraints' => [new Assert\NotBlank()],
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays',
                'constraints' => [new Assert\NotBlank()],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
