<?php

namespace Kwejk\MemsBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddRatingType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('rating', 'type' , array(
                    'type' => 'radio',
                    'value' => 1
                ))
                ->add('rating', 'input', array(
                    'type' => 'radio',
                    'value' => 2
                ))
                ->add('rating', 'input', array(
                    'type' => 'radio',
                    'value' => 3
                    ))
                ->add('rating', 'input', array(
                    'type' => 'radio',
                    'value' => 4
                ))  
                ->add('rating', 'input', array(
                    'type' => 'radio',
                    'value' => 5
                ))
                ->add('save', 'submit')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Kwejk\MemsBundle\Entity\Rating'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'kwejk_memsbundle_rating';
    }

}
