<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 07/01/2018
 * Time: 16:46
 */

namespace App\Application\Middleware;


use App\Infrastructure\View\Twig\TwigRenderer;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Flash\FlashMessagesInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\View\HelperPluginManager;

class TwigMiddlewareFactory
{

    public function __invoke(ContainerInterface $container)
    {
        /** @var TwigRenderer $twigRenderer */
        $twigRenderer = $container->get(TemplateRendererInterface::class);
        $twigEnv = $twigRenderer->getTemplate();
        $helperManeger = $container->get(HelperPluginManager::class);

        return new TwigMiddleware($twigEnv, $helperManeger);
    }
}