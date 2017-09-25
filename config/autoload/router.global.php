<?php

use App\Action\TestePageAction;
use App\Action\TestePageFactory;
use Zend\Expressive\Router\AuraRouter;
use Zend\Expressive\Router\RouterInterface;

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\AuraRouter::class,
            App\Action\PingAction::class => App\Action\PingAction::class
        ],
        'factories' => [
            App\Action\HomePageAction::class => App\Action\HomePageFactory::class
        ],
    ],
];


