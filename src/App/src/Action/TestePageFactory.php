<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 23/09/2017
 * Time: 15:19
 */

namespace App\Action;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class TestePageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $router   = $container->get(RouterInterface::class);
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;
        $manager = $container->get(EntityManager::class);

        return new TestePageAction($manager, $router, $template);
    }
}