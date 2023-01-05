<?php

namespace App\Form;

use App\Entity\Cliente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('razonSocial')
            ->add('representante')
            ->add('domicilio')
            ->add('codigoPostal')
            ->add('email')
            ->add('cuit')
            ->add('nombreFantasia')
            ->add('horario')
            ->add('telefono1')
            ->add('telefono2')
            ->add('observaciones')
            ->add('domicilioEnvios')
            ->add('codigoPostalEnvios')
            ->add('habilitado')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cliente::class,
        ]);
    }
}
