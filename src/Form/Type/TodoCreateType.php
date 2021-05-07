<?php
declare(strict_types=1);
namespace App\Form\Type;

use App\Dto\TodoCreateDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class TodoCreateType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotNull(),
                    new Length([
                        'max' => 60
                    ])
                ]
            ])
            ->add('description', TextType::class, [
                'constraints' => [
                    new NotNull(),
                    new Length([
                        'max' => 200
                    ])
                ]
            ])
            ->add('userId', IntegerType::class, [
                'constraints' => [
                    new NotNull()
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults([
            'data_class' => TodoCreateDto::class
        ]);
    }
}