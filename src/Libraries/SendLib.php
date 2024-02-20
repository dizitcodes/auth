<?php

namespace App\Libraries;

class SendLib
{

    static function Mail($to, $subject, $message, ...$extra)
    {
        $email = \Config\Services::email();

        $config['protocol'] = 'smtp';

        $config['SMTPHost'] = setting('STMP.Host') ?? 'smtp.hostinger.com';
        $config['SMTPUser'] = setting('SMTP.User') ?? 'no-reply@dizit.com.br';
        $config['SMTPPass'] = setting('SMTP.Pass') ?? 'ti3un0cY@';
        $config['SMTPPort'] = setting('SMTP.Port') ?? '587';

        $config['charset']  = setting('SMTP.charset') ?? 'utf-8';
        $config['wordWrap'] = true;
        $config['mailType'] = 'html';

        $email->initialize($config);

        $email->setFrom(setting('SMTP.FromMail') ?? 'no-reply@dizit.com.br', setting('SMTP.FromName') ?? 'Não Responda');
        $email->setTo($to);
        if ($extra['cc'] ?? null) :
            $email->setCC($extra['cc']);
        endif;
        if ($extra['bcc'] ?? null) :
            $email->setBCC($extra['bcc']);
        endif;
        $email->setSubject($subject);
        $email->setMessage($message);

        if (!$email->send()) {
            return false;
        } else {
            return true;
        }
    }
}
