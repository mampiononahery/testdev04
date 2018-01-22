<?php

namespace App\Bundle\MainBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AnnoncesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add( 'title', TextType::class, array(
                'label' => 'Titre',
                'required' => true,
            ) )
            ->add( 'publicationDate', DateType::class, array(
                'label' => 'Date de publication',
                'placeholder' => array(
                    'day' => 'Day',
                    'month' => 'Month',
                    'year' => 'Year',
                ),
                'widget' => 'choice',
                'years' => range(date('2000-01-01'), date('Y')),
                'months' => range(1, 12),
                'days' => range(1, 31),
                'required' => true,
            ) )
            ->add('categorie', EntityType::class, array(
                'class'        => 'App\Bundle\MainBundle\Entity\Categories',
                'choice_label' => 'name',
                'label'        => 'Catégorie',
                'mapped'       => true,
                'multiple'     => true,
                'required'     => true,
            ) )
            ->add( 'description', TextareaType::class, array(
                'label' => 'Déscription',
                'required' => true,
            ) )
            ->add('price', IntegerType::class, array(
                'label' => 'Prix',
                'required' => true,
            ))
            ->add('picture', FileType::class, array(
                'label' => false,
            ))
            ->add( 'save', SubmitType::class, array(
                'label' => 'Envoyer'
            ) );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Bundle\MainBundle\Entity\Annonces',
            'picture' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_bundle_mainbundle_annonces';
    }

}
