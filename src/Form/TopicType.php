<?php

namespace App\Form;

use App\Entity\Topic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'required' => true
            ])
            ->add('description', null, ['attr' => [
                'class' => 'tinymce',
                'style' => '',
                'data-test' => 'coucou',
            ]])
            ->add('reglement', CheckboxType::class, ['mapped' => false])

            /*
            ->add('messages') *tomany
            ->add('tags') *tomany
            */
            /*
             * *tomany : association avec entité existante
             */
            //->add('tags', null, ['choice_label' => 'text'])

            /*
             * *toMany : avec création d'entité : côté client en javascript
             */
            ->add('tags', CollectionType::class, [
                'entry_type' => TagType::class,
                'allow_add' => true,

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Topic::class,
            //'csrf_protection' => false
        ]);
    }
}
