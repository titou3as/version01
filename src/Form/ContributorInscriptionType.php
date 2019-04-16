<?php

namespace App\Form;

use App\Entity\Contributor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContributorInscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,[
                                         'label' => 'Login: ',
                                         'attr' => [
                                                     'placeholder' => 'Tapez votre login ...',
                                                     'class'=>'form-control'
                                              ],
                                        'required' => true,
                    ])
            ->add('password',PasswordType::class,[
                                        'label' => 'Mot de passe : ',
                                        'attr' => [
                                                    'placeholder' => 'Tapez votre mot de passe ...',
                                                    'class'=>'form-control'
                                        ],
                                        'required' => true,
                    ])
            ->add('lastname',TextType::class,[
                                        'label' => 'Nom : ',
                                        'attr' => [
                                                    'placeholder' => 'Tapez votre Nom ...',
                                                    'class'=>'form-control'
                                        ],
                                        'required' => true,
                ])
            ->add('firstname',TextType::class,[
                                        'label' => 'Prénom : ',
                                        'attr' => [
                                                    'placeholder' => 'Tapez votre Prénom ...',
                                                    'class'=>'form-control'
                                        ],
                                        'required' => true,
                ])
            ->add('email',EmailType::class,[
                                            'label' => 'Adresse Email : ',
                                            'attr' => [
                                                    'placeholder' => 'Tapez votre Email ...',
                                                    'class'=>'form-control'
                                                ],
                                            'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contributor::class,
        ]);
    }
}