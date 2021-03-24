<?php

namespace App\Service;

use Twig\Environment;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class MailerService
{
    /**
     * @var MailerInterface
     */
    private $mailer;


    /**
     * MailerService constructor.
     *
     * @param MailerInterface       $mailer
    
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param string $subject
     * @param string $from
     * @param string $to
     * @param string $template
     * @param array $parameters
     * @throws TransportExceptionInterface
   
     */
    public function send(string $subject, string $from, string $to): void
    {
        try {
            $email = (new Email())
                ->from($from)
                ->to($to)
                ->subject($subject);

            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            print $e->getMessage() . "\n";
            throw $e;
        }
    }
}
