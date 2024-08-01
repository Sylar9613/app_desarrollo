<?php

namespace App\Form;

use App\Entity\Objetivo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjetivoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, array(
                'attr'=>array(
                    'class'=>'form-control col-6',
                    'minlength'=>'2',
                    'maxlength'=>'40',
                    'pattern'=>'[á,é,í,ó,ú,Á,É,Í,Ó,ÚA-Za-zñÑ\s\-\.]{2,40}',
                    'title'=>'Nombre de cada objetivo',
                    'onblur'=>'validateFields()',
                    'onkeyup'=>'validateFields()',
                    'tabindex'=>'1',
                    'placeholder'=>'Escriba el objetivo')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Objetivo::class,
        ]);
    }
}
