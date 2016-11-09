<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, ['label'=>'Imie', 'label_attr'=>array('class'=>'myLabel'),'attr'=>['style'=>'margin-left:56px; margin-top:5px;']])
            ->add('lastName', TextType::class, ['label'=>'Nazwisko', 'label_attr'=>array('class'=>'myLabel'),'attr'=>['style'=>'margin-left:21px; margin-top:5px;']])
            ->add('phoneNumber',NumberType::class, ['label'=>'Telefon', 'label_attr'=>array('class'=>'myLabel'),'attr'=>['style'=>'margin-left:37px; margin-top:5px;']])
            ->add('emailAddress', EmailType::class, ['label'=>'E-Mail', 'label_attr'=>array('class'=>'myLabel'),'attr'=>['style'=>'margin-left:40px; margin-top:5px;']])
            ->add('hashPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Hasło', 'label_attr' => ['class' => 'myLabel'], 'attr'=>['style'=>'margin-left:48px; margin-top:5px;']),
                'second_options' => array('label' => 'Powtórz Hasło', 'attr'=>['style'=>'margin-left:5px; margin-top:5px;'])))

        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }
}
