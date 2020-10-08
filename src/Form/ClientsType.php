<?php

namespace App\Form;

use App\Entity\Clients;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
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
            ->add('telephone', TelType::class, ['attr' => array( 'size'=> '42','width'=> '100%','maxlength' => 10, 'id' => 'idTel'), 'label' => 'Téléphone : ', 'label_attr' => array('class' => 'labelClient')])
            ->add('email', EmailType::class, ['label' => 'Email : ', 'label_attr' => array('class' => 'labelClient')])
            ->add('rgpdPanel', CheckboxType::class, ['label' => 'Inscription à la Newsletter :','required' => false,  'label_attr' => array('id' => 'checkLabel', "default" =>false)]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Clients::class
        ]);
    }
}
