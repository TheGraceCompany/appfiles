<?php

namespace App\Services;

/**
 * Class MailInterface.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
interface MailerInterface
{
    public function send($view, $email, $subject, $data = array());
    public function queue($view, $email, $subject, $data = array());
}
