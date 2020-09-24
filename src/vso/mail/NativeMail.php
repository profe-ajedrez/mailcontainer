<?php declare(strict_types=1);

namespace vso\mail;

/**
 * NativeMail
 *
 * This class is an stub and an example, you should write your own mailer class
 * or use an intended mailer like PHPMailer and wrap it up with an instance of
 * InterfaceMailContainer
 */
class NativeMail
{
    /**
     * Email recipients
     * @var     string[]
     */
    protected array $recipients = [];
    protected int $bound = 0;
    protected string $message = '';
    protected string $subject = '';
    protected string $fromAddr = '';
    protected bool $addGreeting = false;
    protected bool $type = true;
    protected string $level = '';
    protected array $attachments = [];

    /**
     * Constructor
     *
     * @access  public
     * @param   bool $greeting
     */
    public function __construct($greeting = false)
    {
        $this->addGreeting = $greeting;
        $this->bound = intval(uniqid('' . time()));
        $this->level = 'normal';
    }

    /**
     * Add an email recipient to send for.
     *
     * @access  public
     * @param   string $email
     * @param   string $name
     * @return  NativeMail
     */
    public function addRecipient(string $email, string $name = null) : NativeMail
    {
        if (!isset($email)) {
            throw new MailerException('Please specify an email!');
        }

        if (isset($name) && !empty($name)) {
            $this->recipients[$name] = $email;
        } else {
            $this->recipients[] = $email;
        }

        return $this;
    }

    /**
     * Set the email content to send.
     *
     * @param   string $msg
     * @return  NativeMail
     */
    public function setMessage(string $msg) : NativeMail
    {
        if (!isset($msg)) {
            throw new MailerException('You must specify a message to send.');
        }

        $this->message = (isset($msg) && !empty($msg)) ? trim(stripslashes($msg)) : null;

        return $this;
    }

    /**
     * Set the email subject
     *
     * @param   string $subject
     * @return  NativeMail
     */
    public function setSubject(string $subject) : NativeMail
    {
        if (!isset($subject)) {
            throw new MailerException('Mail subject expected');
        }

        $this->subject = (isset($subject) && !empty($subject)) ? $subject : null;

        return $this;
    }

    /**
     * Set the email sender
     *
     * @param   string $name
     * @param   string $email
     * @return  NativeMail
     */
    public function setFrom(string $email, string $name = '') : NativeMail
    {
        if (!empty($name)) {
            $this->fromAddr = $name . " <" . $email . ">";
        } else {
            $this->fromAddr = "<" . $email . ">";
        }

        return $this;
    }

    /**
     * Set the email importance level
     *
     * @param   string $lvl
     * @return  NativeMail
     */
    public function setLevel($lvl = 'normal') : NativeMail
    {
        $this->level = (isset($lvl) && !empty($lvl)) ? $lvl : null;

        return $this;
    }

   
    /**
     * Set the email content type
     *
     * @param   string $type
     * @return  object
     */
    public function is($type) : NativeMail
    {
        if (!isset($type)) {
            throw new MailerException('Email type expected');
        }

        $this->type = (isset($type) && !empty($type)) ? $type : null;

        return $this;
    }

    /**
     * Send email to $this->recipients
     *
     * @param   int $pauseEvery
     * @return  bool
     */
    public function send($pauseEvery = 25) : bool
    {
        $count = 1;

        foreach ($this->recipients as $toName => $toAddr) {
            // Increments the counter
            $count++;

            // Every $pauseEvery emails, wait for three seconds
            if (is_int($pauseEvery) && ($count % $pauseEvery) == 0) {
                sleep(3);
            }

            // Now send the email
            if ($this->sendEmail($toAddr, $toName)) {
                // Increment counter
                $count++;
                // Continue
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Send email to the specified address with a greeting with the $toName if greeting is enabled
     *
     * @access  private
     * @param   string $toAddr
     * @param   string $toName
     * @return  bool
     */
    private function sendEmail($toAddr, $toName = null) : bool
    {
        if (!isset($toAddr)) {
            throw new MailerException('Can you please specify an email address C-3PO?');
        }

        // Prepare name and subject
        $toName  = (isset($toName) && is_string($toName))  ? $toName  : 'Sir/Madam';

        // Lunnaly version
        $version = phpversion();

        // Compose body
        $body = ($this->addGreeting === true) ? "Dear, " . $toName . "\n" . $this->message : $this->message;

        // Set headers
        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=utf-8\n";

        if (count($this->attachments) > 0) {
            $headers .= $this->attachments;
        }

        // Send the email
        if (mail($toAddr, $this->subject, $body, $headers)) {
            return true;
        }

        return false;
    }
}
