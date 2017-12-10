<?php

namespace App;

use App\Application\Action\Customer\CustomerCreatePageAction;
use App\Application\Action\Customer\CustomerDeletePageAction;
use App\Application\Action\Customer\CustomerListPageAction;
use App\Application\Action\Customer\CustomerUpdatePageAction;
use App\Application\Action\Customer\Factory\CustomerCreatePageFactory;
use App\Application\Action\Customer\Factory\CustomerDeletePageFactory;
use App\Application\Action\Customer\Factory\CustomerListPageFactory;
use App\Application\Action\Customer\Factory\CustomerUpdatePageFactory;
use App\Application\Action\HomePageAction;
use App\Application\Action\HomePageFactory;
use App\Application\Action\TestePageAction;
use App\Application\Action\TestePageFactory;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates' => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'invokables' => [
                Application\Action\PingAction::class => Application\Action\PingAction::class,
                \Zend\Expressive\Flash\FlashMessageMiddleware::class => \Zend\Expressive\Flash\FlashMessageMiddleware::class,
            ],
            'factories' => [
                HomePageAction::class => HomePageFactory::class,
                TestePageAction::class => TestePageFactory::class,
                CustomerListPageAction::class => CustomerListPageFactory::class,
                CustomerCreatePageAction::class => CustomerCreatePageFactory::class,
                CustomerUpdatePageAction::class => CustomerUpdatePageFactory::class,
                CustomerDeletePageAction::class => CustomerDeletePageFactory::class
            ],
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates()
    {
        return [
            'paths' => [
                'app' => [__DIR__ . '\templates\app'],
                'error' => [__DIR__ . '\templates\error'],
                'layout' => [__DIR__ . '\templates\layout'],
            ],
        ];
    }
}
