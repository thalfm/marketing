<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 12/02/2018
 * Time: 21:52
 */

namespace App\Application\Middleware;


use App\Domain\Service\AuthInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;

class AuthenticationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container) : AuthenticationMiddleware
    {
        $router = $container->get(RouterInterface::class);
        $authService = $container->get(AuthInterface::class);
        return new AuthenticationMiddleware($router,$authService);
    }
}