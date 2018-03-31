<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 07/01/2018
 * Time: 16:20
 */
$forms = [
    'dependencies' => [
        'aliases' => [
        ],
        'invokables' => [
        ],
        'factories'  => [
            \Zend\View\HelperPluginManager::class => \App\Infrastructure\View\HelperPluginManegerFactory::class,
            \App\Application\Form\CustomerForm::class => \App\Application\Form\Factory\CustomerFormFactory::class,
            \App\Application\Form\TagForm::class =>\App\Application\Form\Factory\TagFormFactory::class,
            \App\Application\Form\CampaignForm::class => \App\Application\Form\Factory\CampaignFormFactory::class,
            \App\Application\Form\LoginForm::class => \App\Application\Form\Factory\LoginFormFactory::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
        ],
        'invokables' => [
        ],
        'factories'  => [
            'identity' => ''
        ],
    ]
];

$confiProviderForm = (new \Zend\Form\ConfigProvider())->__invoke();
return Zend\Stdlib\ArrayUtils::merge($confiProviderForm, $forms);