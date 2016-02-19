<?php
/**
 * Form type for the book entity
 *
 * @author    Christian Wasser <christian.wasser@chwasser.de>
 * @since     2016-02-18
 **/

namespace Cwasser\BookShopBundle\V1\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('author')
            ->add('publisher')
            ->add('isbn')
            ->add('language')
            ->add('price');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cwasser\BookShopBundle\V1\Entity\Book',
            'csrf_protection' => false, //Needs to be false for API Ajax calls
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}
