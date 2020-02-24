<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    /**
     * @Route("/mail")
     */
    public function sendEmail(MailerInterface $mailer)
    {

        $email = (new Email())
            ->from('pijus@grazvalda.com')
            ->to('savickas.p@gmail.com')
            ->subject('Registration')
            ->text('Test')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);
        $transport = new GmailSmtpTransport('neatpazintasvartotojas@gmail.com', 'UnknownUser247');
        $mailer = new Mailer($transport);
        $mailer->send($email);
    }
}