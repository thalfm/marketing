<?php

namespace App\Infrastructure\Service;

use Interop\Container\ContainerInterface;
use Mailgun\Mailgun;

class MailgunFactory
{
    public function __invoke(ContainerInterface $container) :Mailgun
    {
        $key = $container->get('config')['mailgun']['key'];
        return new  Mailgun($key);
    }

}
