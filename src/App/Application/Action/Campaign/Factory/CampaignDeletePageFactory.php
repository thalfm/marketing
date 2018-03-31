<?php

namespace App\Application\Action\Campaign\Factory;

use App\Application\Form\CampaignForm;
use Zend\Expressive\Router\RouterInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use App\Domain\Persistence\CampaignRepositoryInterface;
use App\Application\Action\Campaign\CampaignDeletePageAction;

class CampaignDeletePageFactory
{
    public function __invoke(ContainerInterface $container) :CampaignDeletePageAction
    {
        $template = $container->get(TemplateRendererInterface::class);
        $repository = $container->get(CampaignRepositoryInterface::class);
        $router = $container->get(RouterInterface::class);
        $form = $container->get(CampaignForm::class);
        return new CampaignDeletePageAction($repository,$template,$router,$form);
    }
}
