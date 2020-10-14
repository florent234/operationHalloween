<?php

namespace App\Form;

use App\Entity\Clients;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ClientsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('genre', ChoiceType::class, ['label' => 'Genre : ','label_attr' => array('class' => 'labelClient'),  'choices'  => [
                'Madame' => true,
                'Monsieur' => false,
            ],])
            ->add('nom', TextType::class, ['attr' => array('id' => 'idNom') ,'label' => 'Nom : ', 'label_attr' => array('class' => 'labelClient')])
            ->add('prenom', TextType::class, ['label' => 'Prénom : ', 'label_attr' => array('class' => 'labelClient')])
            ->add('telephone', TextType::class, ['attr' => ['maxlength' => '10'], 'label' => 'Téléphone : ', 'label_attr' => array('class' => 'labelClient')])
            ->add('email', EmailType::class, ['label' => 'Email : ', 'label_attr' => array('class' => 'labelClient')])
            ->add('rgpdPanel', CheckboxType::class, ['label' => 'J’accepte de recevoir les actualités et les offres du centre commercial Aushopping Porte du futur :','attr' => array('class' => 'checkbox'), 'required' => false,  'label_attr' => array('id' => 'checkLabel', "default" =>false)])
            ->add('newLetter', CheckboxType::class, ['label' => 'J’accepte de participer au panel de consommateurs Coclicco :','required' => false,'attr' => array('class' => 'checkbox'),  'label_attr' => array('id' => 'checkLabel2', "default" =>false)]);
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Clients::class
        ]);
    }
}
