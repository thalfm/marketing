<?php

namespace App\Infrastructure\Service;

use Interop\Container\ContainerInterface;
use Mailgun\Mailgun;
use Zend\Expressive\Template\TemplateRendererInterface;


class CampaignEmailSenderFactory
{
    public function __invoke(ContainerInterface $container) :CampaignEmailSender
    {
        $template = $container->get(TemplateRendererInterface::class);
        $mailGun = $container->get(Mailgun::class);
        $emailGunConfig = $container->get('config')['mailgun'];
        return new CampaignEmailSender($template, $mailGun, $emailGunConfig);
    }

}
