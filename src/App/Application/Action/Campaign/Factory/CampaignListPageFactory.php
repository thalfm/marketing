<?php

namespace App\Application\Action\Campaign\Factory;

use Interop\Container\ContainerInterface;
use Mailgun\Mailgun;
use Zend\Expressive\Template\TemplateRendererInterface;
use App\Domain\Persistence\CampaignRepositoryInterface;
use App\Application\Action\Campaign\CampaignListPageAction;


class CampaignListPageFactory
{
    public function __invoke(ContainerInterface $container) :CampaignListPageAction
    {
        $template = $container->get(TemplateRendererInterface::class);
        $repository = $container->get(CampaignRepositoryInterface::class);
        $emailGun = $container->get(Mailgun::class);
        return new CampaignListPageAction($repository,$template,$emailGun);
    }
}
