<?php

namespace App\Form;

use App\Entity\AccionPAM;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccionPAMType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextareaType::class, array(
                'attr'=>array(
                    'class'=>'form-control',
                    'tabindex'=>'1',
                    'cols'=>'45',
                    'rows'=>'3',
                    'title'=>'Acciones',
                    'minlength'=>'1',
                    'maxlength'=>'65525',
                    'onblur'=>'validateFields("1")',
                    'aria-required'=>'true',
                    'placeholder'=>'Enter acción'),
                'label'=>'Nombre'))
            /*->add('fecha', TextType::class, array(
                'label_attr'=>array(
                    'class'=>'float-right',
                    'style'=>'padding: 0; margin-right:400px; margin-top:20px;',
                ),
                'label'=>'Fecha',
                'attr'=>array(
                    'class'=>'form-control float-right',
                    'minlength'=>'3',
                    'maxlength'=>'120',
                    'pattern'=>'[á,é,í,ó,ú,Á,É,Í,Ó,Ú0-9A-Za-zñÑ\s\-\.]{3,120}',
                    'title'=>'Fecha',
                    'onblur'=>'validateFields("3")',
                    'onkeyup'=>'validateFields("3")',
                    'tabindex'=>'3',
                    'style'=>'width: 400px; margin-top: 48px; margin-right:-452px;',
                    'placeholder'=>'Enter fecha')
            ))*/
            ->add('responsables', TextType::class, array(
                'label_attr'=>array(
                    'style'=>'margin-top:25px;',
                ),
                'attr'=>array(
                    'class'=>'form-control',
                    'minlength'=>'3',
                    'maxlength'=>'255',
                    'pattern'=>'[á,é,í,ó,ú,Á,É,Í,Ó,Ú0-9A-Za-zñÑ\s\-\.]{3,255}',
                    'title'=>'Responsables',
                    'onblur'=>'validateFields("2")',
                    'onkeyup'=>'validateFields("2")',
                    'tabindex'=>'2',
                    'style'=>'width: 400px;',
                    'placeholder'=>'Enter responsables')))
            ->add('fecha', TextType::class, array(
                'label_attr'=>array(
                    'style'=>'margin-top:25px;',
                ),
                'label'=>'Fecha',
                'attr'=>array(
                    'class'=>'form-control',
                    'minlength'=>'3',
                    'maxlength'=>'120',
                    'pattern'=>'[á,é,í,ó,ú,Á,É,Í,Ó,Ú0-9A-Za-zñÑ\s\-\.]{3,120}',
                    'title'=>'Fecha',
                    'onblur'=>'validateFields("3")',
                    'onkeyup'=>'validateFields("3")',
                    'tabindex'=>'3',
                    'style'=>'width: 400px; margin-bottom: 25px;',
                    'placeholder'=>'Enter fecha')
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AccionPAM::class,
        ]);
    }
}
