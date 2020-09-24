<?php declare(strict_types=1);

namespace vso\mailcontainer;

use \vso\mail\NativeMail;

/**
 * NativeMailContainer
 *
 * Wraps up NativeMail class as adapter implementing InterfaceMailContainer
 *
 */
class NativeMailContainer implements InterfaceMailContainer
{
    private NativeMail $mailer;

    
    public function __construct()
    {
        $this->mailer = new NativeMail();
    }

    public function getMailer()
    {
        return $this->mailer;
    }

    
    public function setTarget(array $targets) : void
    {
        foreach ($targets as $recipient) {
            if (is_string($recipient)) {
                $this->mailer->addRecipient($recipient);
            }
        }
    }
    
    
    public function setSubject(string $subject) : void
    {
        $this->mailer->setSubject($subject);
    }

    
    public function setSender(string $sender) : void
    {
        $this->mailer->setFrom($sender);
    }


    public function setBody(string $body) : void
    {
        $this->mailer->setMessage($body);
    }

    
    public function send() : void
    {
        $this->mailer->send();
    }


    public function sendMail(string $from, array $to, string $subject, string $body) : void
    {
        $this->setTarget($to);
        $this->setSender($from);
        $this->setSubject($subject);
        $this->setBody($body);
        $this->send();
    }
}
