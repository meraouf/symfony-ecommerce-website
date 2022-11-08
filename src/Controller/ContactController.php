<?php

namespace App\Controller;

use App\classe\Mail;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/nous-contacter", name="contact")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->addFlash('notice', 'Merci de nous avoir contacter. Notre équipe va vous répondre dans les meilleurs délais.');

//            $mail = new Mail();
//            $mail->send('admin_adress@monsite.com','nom de boutique','sujet', 'contenu');
        }
        return $this->render('contact/index.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
