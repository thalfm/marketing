<?php

namespace App\Application\Action\Tag\Factory;

use App\Application\Form\TagForm;
use Zend\Expressive\Router\RouterInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use App\Domain\Persistence\TagRepositoryInterface;
use App\Application\Action\Tag\TagDeletePageAction;

class TagDeletePageFactory
{
    public function __invoke(ContainerInterface $container) :TagDeletePageAction
    {
        $template = $container->get(TemplateRendererInterface::class);
        $repository = $container->get(TagRepositoryInterface::class);
        $router = $container->get(RouterInterface::class);
        $form = $container->get(TagForm::class);
        return new TagDeletePageAction($repository,$template,$router,$form);
    }
}
