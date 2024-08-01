<?php

namespace App\Form;

use App\Entity\Entidad;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntidadType extends AbstractType
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
                    'title'=>'Nombre de cada entidad del sistema',
                    'onblur'=>'validateFields("1")',
                    'onkeyup'=>'validateFields("1")',
                    'tabindex'=>'1',
                    'style'=>'width: 450px;',
                    'placeholder'=>'Enter entidad')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entidad::class,
        ]);
    }
}