<?php

namespace App\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,
            [
                "label" => "Prénom",
                "constraints" => [
                    new NotBlank(
                        [
                            "message" => "Le champs ne peut pas être vide"
                        ]
                    )
                ]
            ])
            ->add('lastname', TextType::class,
                [
                    "label" => "Nom",
                    "constraints" => [
                        new NotBlank(
                            [
                                "message" => "Le champs ne peut pas être vide"
                            ]
                        )
                    ]
                ])
            ->add("mail", EmailType::class,[
                "label" => "Adresse mail",
                "constraints" => [
                    new Email(
                        [
                            "message" => "L'adresse mail n'est pas assez complexe",
                            "mode" => "html5"
                        ]
                    ),
                    new Length(
                        [
                            "min" => 6,
                            "minMessage" => "L'adresse mail est trop courte"
                        ]
                    )
                ]
            ])
            ->add("message", CKEditorType::class,[
                "label" => "Message",
                "constraints" => [
                    new Length(
                        [
                            "min" => 1,
                            "max" => 1500,
                            "minMessage" => "Veuillez saisir un message",
                            "maxMessage" => "Le message est trop long"
                        ]
                    )
                ]
            ])
            ->add("submit", SubmitType::class,[
                "label" => "envoyer"
            ])
            ->add("captcha", Recaptcha3Type::class, [
                "constraints" => new Recaptcha3(
                    [
                        "message" => "Échec de vérification du captcha",
                        "messageMissingValue" => "La valeur du captcha est manquante"
                    ]
                )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
