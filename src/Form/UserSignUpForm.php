<?php

namespace App\Form;

use App\Entity\AdminRole;
use App\Entity\GuestRole;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class TaskType
 * @package App\Form
 */
class UserSignUpForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'autofocus' => 'enabled',
                ]
            ])
            ->add('pass', PasswordType::class)
            ->add('email', EmailType::class)
            ->add('role', ChoiceType::class, [
                'choices' => [
                    /** @todo Get roles from service */
                    new GuestRole(),
                    new AdminRole(),
                ],
                'choice_label' => function($role) {
                    /** @var IRole $role */
                    return ucfirst($role);
                },
                'choice_value' => function($role) {
                    /** @var IRole $role */
                    return (string) $role;
                }
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn btn-lg btn-primary btn-block',
                ],
            ])
        ;
    }
}
