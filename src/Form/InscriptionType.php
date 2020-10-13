<?php

namespace App\Form;

use App\Entity\Photo;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class InscriptionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('username', TextType::class, ['label' => 'Pseudo : ', 'label_attr' => array('class' => 'labelClient')])
            ->add('prenom', TextType::class, ['label' => 'Prenom : ', 'label_attr' => array('class' => 'labelClient')])
            ->add('nom', TextType::class, ['label' => 'Nom : ', 'label_attr' => array('class' => 'labelClient')])
            ->add('telephone', TextType::class, ['attr' => ['maxlength' => '10'],'label' => 'Téléphone : ', 'label_attr' => array('class' => 'labelClient')])
            ->add('email', EmailType::class, ['label' => 'Email : ', 'label_attr' => array('class' => 'labelClient')])
            ->add('password', RepeatedType::class, ['type'=>PasswordType::class,
                'invalid_message' => 'les mots de passes ne correspondent pas',
                'required'=>true,
                'first_options'=>array('label'=>'Mot de passe :', 'label_attr' => array('class' => 'labelClient')),
                'second_options'=>array('label'=>'Répéter mot de passe :', 'label_attr' => array('class' => 'labelClient'))])
            ->add('administrateur', ChoiceType::class, ['data_class' => null,'label_attr' => array('class' => 'labelClient'),'label' => 'Administrateur : ', 'choices'=> ['Oui'=>true, 'Non'=>false],'attr' => array('class' => 'checkbox')])
            ->add('actif', ChoiceType::class, ['data_class' => null,'label_attr' => array('class' => 'labelClient'), 'label' => 'Actif : ', 'choices'=> ['Oui'=>true, 'Non'=>false],'attr' => array('class' => 'checkbox')])
            ->add('IdPhoto', FileType::class, array('data_class' => null, 'label'=>'Choisissez une photo : ', 'label_attr' => array('class' => 'labelClient')))
            ;

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
