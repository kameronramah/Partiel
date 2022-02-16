<?php

namespace App\Form;

use App\Entity\Memo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType as TypeIntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $minutes = [];
        for ($i=1; $i < 181; $i++) { 
            $time = ' minutes';
            if($i == 1) {
                $time = ' minute';
            }
            $minutes[$i . $time] = $i;
        }

        $builder
            ->add('content', TypeTextType::class, [
                'required' => true,
                'label' => 'Contenu :'
            ])
            ->add('deletedTime', ChoiceType::class, [
                'placeholder' => '...',
                'choices' => $minutes,
                'required' => true,
                'label' => 'Délai d\'expiration : ',
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Memo::class,
        ]);
    }
}
