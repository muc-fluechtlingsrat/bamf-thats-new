<?php

function sendMail($urlsString) {
    $transport = Swift_SmtpTransport::newInstance(smtp_host, smtp_port, smtp_transport)
      ->setUsername(smtp_user)
      ->setPassword(smtp_password);


    $mailer = Swift_Mailer::newInstance($transport);

    $body = "Hi 👋

BAMF: Thats's new found the following new URLs:

$urlsString

Best regards
BAMF: That's new
";

    $message = Swift_Message::newInstance('BAMF: Thats\'s new has news')
        ->setFrom(array(sender_address => sender_name))
        ->setTo(explode(',', mail_reveiver))
        ->setBody($body, 'text/plain');

    $isMailSent = $mailer->send($message);

    if($isMailSent) {
        print "\n\nMail(s) sent!\n";
    }
    else {
        print "\n\nMail submission failed :(\n";
    }
}
