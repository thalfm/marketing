<?php

use App\Application\Middleware\TwigMiddleware;
use App\Application\Middleware\TwigMiddlewareFactory;
use App\Domain\Persistence\CampaignRepositoryInterface;
use App\Domain\Persistence\CustomerRepositoryInterface;
use App\Domain\Persistence\TagRepositoryInterface;
use App\Domain\Persistence\UserRepositoryInterface;
use App\Domain\Service\CampaignEmailSenderInterface;
use App\Infrastructure\Persistence\Doctrine\Repository\CampaignRepositoryFactory;
use App\Infrastructure\Persistence\Doctrine\Repository\CustomerRepositoryFactory;
use App\Infrastructure\Persistence\Doctrine\Repository\TagRepositoryFactory;
use App\Infrastructure\Persistence\Doctrine\Repository\UserRepositoryFactory;
use App\Infrastructure\Service\CampaignEmailSenderFactory;
use App\Infrastructure\Service\Doctrine\DoctrineArrayCacheFactory;
use App\Infrastructure\Service\Doctrine\DoctrineFactory;
use App\Infrastructure\Service\MailgunFactory;
use Mailgun\Mailgun;
use Zend\Expressive\Application;
use Zend\Expressive\Container;
use Zend\Expressive\Delegate;
use Zend\Expressive\Helper;
use Zend\Expressive\Middleware;

return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.
    'dependencies' => [
        // Use 'aliases' to alias a service name to another service. The
        // key is the alias name, the value is the service to which it points.
        'aliases' => [
            'Zend\Expressive\Delegate\DefaultDelegate' => Delegate\NotFoundDelegate::class,
            'Configuration' => 'config', //Doctrine needs a service called Configuration
            'Config' => 'config', //Doctrine needs a service called Configuration
            //\Zend\Authentication\AuthenticationService::class => 'doctrine.authenticationservice.orm_default',
            Zend\Expressive\Authentication\UserRepositoryInterface::class => Zend\Expressive\Authentication\UserRepository\PdoDatabase::class,
        ],
        // Use 'invokables' for constructor-less services, or services that do
        // not require arguments to the constructor. Map a service name to the
        // class name.
        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
            Helper\ServerUrlHelper::class => Helper\ServerUrlHelper::class,
        ],
        // Use 'factories' for services provided by callbacks/factory classes.
        'factories'  => [
            Application::class                => Container\ApplicationFactory::class,
            Delegate\NotFoundDelegate::class  => Container\NotFoundDelegateFactory::class,
            Helper\ServerUrlMiddleware::class => Helper\ServerUrlMiddlewareFactory::class,
            Helper\UrlHelper::class           => Helper\UrlHelperFactory::class,
            Helper\UrlHelperMiddleware::class => Helper\UrlHelperMiddlewareFactory::class,
            TwigMiddleware::class             => TwigMiddlewareFactory::class,

            Mailgun::class => MailgunFactory::class,
            CampaignEmailSenderInterface::class => CampaignEmailSenderFactory::class,
            //AuthenticationMiddleware::class   => AuthenticationMiddlewareFactory::class,

            Zend\Stratigility\Middleware\ErrorHandler::class => Container\ErrorHandlerFactory::class,
            Middleware\ErrorResponseGenerator::class         => Container\ErrorResponseGeneratorFactory::class,
            Middleware\NotFoundHandler::class                => Container\NotFoundHandlerFactory::class,

            Doctrine\Common\Cache\Cache::class => DoctrineArrayCacheFactory::class,
            Doctrine\ORM\EntityManager::class  => DoctrineFactory::class,
            CustomerRepositoryInterface::class => CustomerRepositoryFactory::class,
            TagRepositoryInterface::class => TagRepositoryFactory::class,
            CampaignRepositoryInterface::class => CampaignRepositoryFactory::class,
            UserRepositoryInterface::class => UserRepositoryFactory::class,
            'doctrine:fixtures_cmd:load'   => \CodeEdu\FixtureFactory::class,
            //AuthInterface::class => AuthServiceFactory::class
            Zend\Expressive\Authentication\AuthenticationInterface::class => Zend\Expressive\Authentication\Session\PhpSessionFactory::class,
        ],
    ],
];
