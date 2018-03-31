<?php

namespace App\Application\Action\Campaign\Factory;

use App\Application\Form\CampaignForm;
use Zend\Expressive\Router\RouterInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use App\Domain\Persistence\CampaignRepositoryInterface;
use App\Application\Action\Campaign\CampaignCreatePageAction;

class CampaignCreatePageFactory
{
    public function __invoke(ContainerInterface $container) :CampaignCreatePageAction
    {
        $template = $container->get(TemplateRendererInterface::class);
        $repository = $container->get(CampaignRepositoryInterface::class);
        $router = $container->get(RouterInterface::class);
        $form = $container->get(CampaignForm::class);
        return new CampaignCreatePageAction($repository,$template,$router,$form);
    }
}
