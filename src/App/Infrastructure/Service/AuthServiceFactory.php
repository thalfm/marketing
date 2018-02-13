<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 12/02/2018
 * Time: 20:20
 */

namespace App\Infrastructure\Service;


use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;

class AuthServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $authenticationService = $container->get(AuthenticationService::class);
        return new AuthService($authenticationService);
    }
}