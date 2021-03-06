<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class TaskType.
 */
class UserSignUpForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'autofocus' => 'enabled',
                ],
            ])
            ->add('pass', PasswordType::class)
            ->add('email', EmailType::class)
            ->add('role', ChoiceType::class, [
                'choices' => [
                    /* @todo Get roles from service */
                    new Role(Role::GUEST),
                    new Role(Role::ADMIN),
                ],
                'choice_label' => function ($role) {
                    /* @var IRole $role */
                    return ucfirst((string) $role);
                },
                'choice_value' => function ($role) {
                    /* @var IRole $role */
                    return (string) $role;
                },
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn btn-lg btn-dark btn-block',
                ],
            ])
        ;
    }
}
