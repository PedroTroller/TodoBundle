<?php

namespace Knib\TodoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email', 'email')
            ->add('rawPassword', 'repeated', array(
            'type' => 'password',
            'first_options' => array('label' => 'Password'),
            'second_options' => array('label' => 'Confirmation'),
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Knib\TodoBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'User';
    }
}
