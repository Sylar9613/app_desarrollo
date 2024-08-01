<?php

namespace App\Form;

use App\Entity\ObjetivoEntidad;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjetivoEntidadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('acciones', EntityType::class,
                array(
                    'class' => 'App\Entity\Accion',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('i')
                            ->where('i.activo=1')
                            ->orderBy('i.nombre', 'ASC');
                    },
                    'choice_label' => 'nombre',
                    /*'placeholder' => 'Todas'*/
                    'attr'=>array('class'=>'form-control', 'style'=>'width: 450px; margin-right:-450px;', 'tabindex'=>'1')
                ))
            ->add('deficiencias', TextareaType::class, array(
                'attr'=>array(
                    'class'=>'form-control',
                    'tabindex'=>'2',
                    'cols'=>'45',
                    'rows'=>'3',
                    'title'=>'Deficiencias detectadas',
                    'minlength'=>'0',
                    'maxlength'=>'65525',
                    'onblur'=>'validateFields("1")',
                    'aria-required'=>'false',
                    'placeholder'=>'Enter deficiencia'),
                'label'=>'Deficiencias detectadas'))
            ->add('recomendaciones', TextareaType::class, array(
                'attr'=>array(
                    'class'=>'form-control',
                    'tabindex'=>'3',
                    'cols'=>'45',
                    'rows'=>'3',
                    'title'=>'Recomendaciones sugeridas',
                    'minlength'=>'0',
                    'maxlength'=>'65525',
                    'onblur'=>'validateFields("2")',
                    'aria-required'=>'false',
                    'placeholder'=>'Enter recomendaciones'),
                'label'=>'Recomendaciones'))
            ->add('seguimiento', TextareaType::class, array(
                'attr'=>array(
                    'class'=>'form-control',
                    'tabindex'=>'4',
                    'cols'=>'45',
                    'rows'=>'3',
                    'title'=>'Seguimiento al problema detectado',
                    'minlength'=>'0',
                    'maxlength'=>'65525',
                    'onblur'=>'validateFields("3")',
                    'aria-required'=>'false',
                    'placeholder'=>'Enter seguimiento'),
                'label'=>'Seguimiento'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ObjetivoEntidad::class,
        ]);
    }
}
