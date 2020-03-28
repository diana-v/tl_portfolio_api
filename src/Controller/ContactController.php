<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Contact;
use App\Form\Type\ContactType;

class ContactController extends AbstractController
{
    public function submit(\Swift_Mailer $mailer, Request $request)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $data = $request->request->all();
        $form->submit($data);

        if ($form->isSubmitted() && !$form->isValid()) {
            return new Response($form->getErrors(true, false), 400);
        }

        $email_form = (new \Swift_Message('Nauja žinutė iš: ' . $data['name'] ))
            ->setFrom($_ENV['MAILER_FROM'])
            ->setTo($_ENV['MAILER_TO'])
            ->setBody(
                $this->renderView(
                    'emails/contact.html.twig',
                    $data
                ),
                'text/html'
            )
            ->addPart(
                $this->renderView(
                    'emails/contact.txt.twig',
                    $data
                ),
                'text/plain'
            );

        $mailer->send($email_form);
        return new Response('Success', 200, [
            'Access-Control-Allow-Origin' => '*'
        ]);
    }
}