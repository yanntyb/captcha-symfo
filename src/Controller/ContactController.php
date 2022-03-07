<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/contact", "contact_")]
class ContactController extends AbstractController
{
    #[Route('/mail', name: 'mail')]
    public function index(Request $req, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){
            $firstname = $form->get("firstname")->getData();
            $lastname = $form->get("lastname")->getData();
            $mailAdresse = $form->get("mail")->getData();
            $message = $form->get("message")->getData();

            $mail = new Email();
            $mail
                ->from($mailAdresse)
                ->to("admin@yanntb.com")
                ->subject("Mail de $firstname $lastname")
                ->text($message);

            try{
                $mailer->send($mail);
                $this->addFlash("success", "Votre message a bien été envoyé");
            }
            catch(TransportExceptionInterface $e){
                $this->addFlash("error", "Une erreur c'est produite lors de l'envoie du mail");
            }
        }

        return $this->render('contact/index.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }
}
