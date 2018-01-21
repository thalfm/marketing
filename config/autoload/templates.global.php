<?php

use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Expressive\Twig\TwigEnvironmentFactory;

return [
    'dependencies' => [
        'factories' => [
            Twig_Environment::class => TwigEnvironmentFactory::class,
            TemplateRendererInterface::class => \App\Infrastructure\View\Twig\TwigRendererFactory::class,
        ],
    ],

    'templates' => [
        'extension' => 'html.twig',
    ],

    'twig' => [
        'debug' => true,
        'cache_dir'      => 'data/cache/twig',
        'assets_url'     => '/',
        'assets_version' => null,
        'extensions'     => [
            // extension service names or instances
        ],
        'runtime_loaders' => [
            // runtime loader names or instances
        ],
        'globals' => [
            // Variables to pass to all twig templates
        ],
        // 'timezone' => 'default timezone identifier; e.g. America/Chicago',
    ],
];
