<?php

namespace App\Application\Action\Tag\Factory;

use App\Application\Form\TagForm;
use Zend\Expressive\Router\RouterInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use App\Domain\Persistence\TagRepositoryInterface;
use App\Application\Action\Tag\TagUpdatePageAction;

class TagUpdatePageFactory
{
    public function __invoke(ContainerInterface $container) :TagUpdatePageAction
    {
        $template = $container->get(TemplateRendererInterface::class);
        $repository = $container->get(TagRepositoryInterface::class);
        $router = $container->get(RouterInterface::class);
        $form = $container->get(TagForm::class);
        return new TagUpdatePageAction($repository,$template,$router,$form);
    }
}
