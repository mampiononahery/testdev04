<?php

namespace App\Bundle\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RegistrationType
 * @package Aes\Bundle\UserBundle\Form
 */
class RegistrationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text', array(
                'label' => 'Nom',
            ))
                
            ->add('lastname', 'text', array(
                'label' => 'Prénom',
            ))
                
            ->add('address', 'text', array(
                'label' => 'Adresse',
            ))
                
            ->add('address2', 'text', array(
                'label' => "Complément d'adresse",
                'required' => false
            ))
                
            ->add('phone', 'text', array(
                'label' => 'Téléphone',
            ))
                
            ->add('cp', 'text', array(
                'label' => 'Code postal',
            ))
                
            ->add('city', 'text', array(
                'label' => 'Ville',
            ))
        ;
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}