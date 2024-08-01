<?php

namespace App\Form;

use App\Entity\Accion;
use App\Entity\TipoAccion;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, array(
                'attr'=>array(
                    'class'=>'form-control',
                    'minlength'=>'3',
                    'maxlength'=>'70',
                    'pattern'=>'[á,é,í,ó,ú,Á,É,Í,Ó,Ú0-9A-Za-zñÑ\s\-\.]{3,70}',
                    'title'=>'Nombre de cada acción',
                    'onblur'=>'validateFields("1")',
                    'onkeyup'=>'validateFields("1")',
                    'tabindex'=>'1',
                    'style'=>'width: 450px;',
                    'placeholder'=>'Enter acción')))
            ->add('tipoaccion', EntityType::class,
                array(
                    'label'=>'Tipo de acción',
                    'label_attr'=>array(
                        'class'=>'float-right',
                        'style'=>'padding: 0; margin-right:395px;'
                    ),
                    'class' => 'App\Entity\TipoAccion',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('i')
                            ->where('i.activo=1')
                            ->orderBy('i.nombre', 'ASC');
                    },
                    'choice_label' => 'nombre',
                    /*'placeholder' => 'Todas'*/
                    'attr'=>array('class'=>'form-control float-right', 'style'=>'width: 450px; margin-top: 28px; margin-right:-450px;', 'tabindex'=>'2')
            ))
            ->add('fecha', DateType::class,
                array(
                    'label'=>'Fecha de ejecución',
                    'label_attr'=>array(
                        'style'=>'padding: 0; width: 50%;',
                    ),
                    'attr'=>array(
                        'style'=>'width: 450px;',
                        'tabindex'=>'5',
                        'title'=>'Fecha de ejecución',
                        'onblur'=>'validateFields("2")',
                        'onkeyup'=>'validateFields("2")',
                        'class'=>'form-control'),
                    /*'data' => new \DateTime('now'),*/
                    'widget' => 'single_text',
                    /*'html5' => false,*/
                    ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Accion::class,
        ]);
    }
}
