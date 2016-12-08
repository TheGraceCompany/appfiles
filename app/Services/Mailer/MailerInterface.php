<?php

/*
 * @author Phillip Madsen
 */

namespace App\Services;

/**
 * Class MailInterface.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
interface MailerInterface
{
    public function send($view, $email, $subject, $data = []);

    public function queue($view, $email, $subject, $data = []);
}
