<?php

namespace AppBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
            ->add('price',NumberType::class, ['label' => 'Cena', 'label_attr'=> array('class'=>'myLabel'), 'attr'=> array('style'=>'margin-left:11px;margin-top:5px;')])
            ->add('type',EntityType::class, array('class' => 'AppBundle\Entity\ProductType', 'label' => 'Rodzaj', 'label_attr' => array('class' =>'myLabel'), 'attr' => array('style' => 'margin-left:1px;margin-top:5px;width:156px;')))
            ->add('description',TextType::class, ['label' => 'Opis', 'label_attr'=> array('class'=>'myLabel'), 'attr'=> array('style'=>'margin-left:14px;margin-top:5px;')])
            ->add('amountOfStock',TextType::class, ['label' => 'Ilosc', 'label_attr'=> array('class'=>'myLabel'), 'attr'=> array('style'=>'margin-left:13px;margin-top:5px;')])
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
