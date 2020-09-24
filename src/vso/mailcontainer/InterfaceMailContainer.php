<?php declare(strict_types=1);

namespace vso\mailcontainer;

/**
 * InterfaceMailContainer
 *
 * This interface defines the adapter that classes which encapsulate mailer object
 * should follow.
 *
 * So, one for instance coul write a class that sends mail using php native mail() function,
 * then that class should be encapsulated in other class implementing this interface.-white.
 * The same should be done if you use other mailer object like an instance of PHPMailer
 *
 */
interface InterfaceMailContainer
{
    /**
     * getMailer
     *
     * returns the mailer object which is being encapsulated in this container
     * (ex. a instance of PHPMailer or some custom mailer class)
     * @return Object
     */
    public function getMailer();

    /**
     * setTarget
     *
     * Sets who is going to gets the sended mail
     *
     * @param string[] $targets
     * @return void
     * @throws InvalidArgumentException
     */
    public function setTarget(array $targets) : void;

    /**
     * setSubject
     *
     * Sets the subject of the to send mail
     *
     * @param string $subject
     * @return void
     * @throws InvalidArgumentException
     */
    public function setSubject(string $subject) : void;

    /**
     * setSender
     *
     * Sets who is going to send the mail
     * @param string $sender
     * @return void
     * @throws InvalidArgumentException
     */
    public function setSender(string $sender) : void;

    /**
     * setBody
     *
     * Sets the body of the to send mail
     *
     * @param string $body
     * @return void
     * @throws InvalidArgumentException
     */
    public function setBody(string $body) : void;

    /**
     * send
     *
     * Just sends the mail.
     *
     * @return void
     */
    public function send() : void;


    public function sendMail(string $from, array $to, string $subject, string $body) : void;
}
