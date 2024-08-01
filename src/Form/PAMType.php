<?php

namespace App\Form;

use App\Entity\LineaEstrategica;
use App\Entity\PAM;
use App\Repository\LineaEstrategicaRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PAMType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, array(
                'label_attr'=>array(
                    'style'=>'margin-top:25px;',
                ),
                'attr'=>array(
                    'class'=>'form-control',
                    'minlength'=>'3',
                    'maxlength'=>'255',
                    'pattern'=>'[á,é,í,ó,ú,Á,É,Í,Ó,Ú0-9A-Za-zñÑ\s\-\.]{3,150}',
                    'title'=>'Nombre',
                    'onblur'=>'validateFields("2")',
                    'onkeyup'=>'validateFields("2")',
                    'tabindex'=>'2',
                    'style'=>'width: 400px;',
                    'placeholder'=>'Enter nombre del plan')))
            ->add('resultados_esperados', TextareaType::class, array(
                'label_attr'=>array(
                    'style'=>'margin-top:25px;',
                ),
                'attr'=>array(
                    'class'=>'form-control',
                    'tabindex'=>'1',
                    'cols'=>'45',
                    'rows'=>'3',
                    'title'=>'Resultados esperados',
                    'minlength'=>'1',
                    'maxlength'=>'65525',
                    'onblur'=>'validateFields("1")',
                    'aria-required'=>'true',
                    'placeholder'=>'Enter resultados'),
                'label'=>'Resultados esperados'))
            /*->add('lineas', CollectionType::class, array(
                'entry_type' => LineaEstrategicaType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Líneas Estratégicas',
                'label_attr'=>array(
                    'style'=>'margin-top:25px;',
                ),
                'prototype' => true,
                'prototype_name' => '__linea__'
            ))*/
            ->add('lineas', EntityType::class, array(
                'class' => LineaEstrategica::class,
                'choice_label' => 'nombre',
                'multiple' => true,
                'expanded' => true,
                'choice_attr'=>function($val, $key, $index) {
                    if ($val=='ROLE_USER')
                        return ['checked'=>'checked', 'style' => 'cursor:pointer;','class' => 'my-checkbox','tabindex'=>'3'];
                    if ($val=='ROLE_SUPER_ADMIN')
                        return ['style' => 'cursor:pointer; margin-right:5px;','tabindex'=>'3'/*, 'disabled'=>'disabled'*/];
                    return ['class' => 'my-checkbox disabled', 'style' => 'cursor:pointer;','tabindex'=>'3'];
                },
                'attr'=>array(
                    'title'=>'Líneas estratégicas'),
                'label'=>'Líneas estratégicas',
                'label_attr'=>array(
                    'style'=>'margin-top:25px;',
                ),
            ))
            ->add('cuantitativos', TextareaType::class, array(
                'label_attr'=>array(
                    'style'=>'margin-top:25px;',
                ),
                'label'=>'Indicadores cuantitativos',
                'attr'=>array(
                    'class'=>'form-control',
                    'cols'=>'45',
                    'rows'=>'3',
                    'minlength'=>'1',
                    'maxlength'=>'65525',
                    'title'=>'Indicadores cuantitativos del plan',
                    'tabindex'=>'4',
                    'placeholder'=>'Enter indicadores cuantitativos')))
            ->add('cualitativos', TextareaType::class, array(
                'label_attr'=>array(
                    'style'=>'margin-top:25px;',
                ),
                'label'=>'Indicadores cualitativos',
                'attr'=>array(
                    'class'=>'form-control',
                    'cols'=>'45',
                    'rows'=>'3',
                    'minlength'=>'1',
                    'maxlength'=>'65525',
                    'title'=>'Indicadores cualitativos del plan',
                    'tabindex'=>'5',
                    'placeholder'=>'Enter indicadores cualitativos')))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PAM::class,
        ]);
    }
}
