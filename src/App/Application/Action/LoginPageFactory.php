<?php

namespace App\Application\Action;

use App\Application\Form\LoginForm;
use App\Domain\Service\AuthInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class LoginPageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $router = $container->get(RouterInterface::class);
        $template = $container->get(TemplateRendererInterface::class);
        $form = $container->get(LoginForm::class);
        return new LoginPageHandle($router, $template, $form);
    }
}
