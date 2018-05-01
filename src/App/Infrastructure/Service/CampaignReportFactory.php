<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 01/05/2018
 * Time: 15:22
 */

namespace App\Infrastructure\Service;


use App\Domain\Persistence\CustomerRepositoryInterface;
use Interop\Container\ContainerInterface;
use Mailgun\Mailgun;
use Zend\Expressive\Template\TemplateRendererInterface;

class CampaignReportFactory
{
    public function __invoke(ContainerInterface $container) :CampaignReport
    {
        $template = $container->get(TemplateRendererInterface::class);
        $mailGun = $container->get(Mailgun::class);
        $emailGunConfig = $container->get('config')['mailgun'];
        $repository = $container->get(CustomerRepositoryInterface::class);
        return new CampaignReport($template, $mailGun, $emailGunConfig, $repository);
    }
}