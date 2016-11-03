<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, ['label' => 'Nazwa', 'label_attr'=> array('class'=>'myLabel')])
            ->add('price',TextType::class, ['label' => 'Cena', 'label_attr'=> array('class'=>'myLabel'), 'attr'=> array('style'=>'margin-left:10px;margin-top:5px;')])
            ->add('type',TextType::class, ['label' => 'Typ', 'label_attr'=> array('class'=>'myLabel'), 'attr'=> array('style'=>'margin-left:17px;margin-top:5px;')])
            ->add('description',TextType::class, ['label' => 'Opis', 'label_attr'=> array('class'=>'myLabel'), 'attr'=> array('style'=>'margin-left:12px;margin-top:5px;')])
            ->add('amountOfStock',TextType::class, ['label' => 'Ilosc', 'label_attr'=> array('class'=>'myLabel'), 'attr'=> array('style'=>'margin-left:11px;margin-top:5px;')])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product'
        ));
    }
}
