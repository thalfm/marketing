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
            \Zend\View\HelperPluginManager::class => \App\Infrastructure\View\HelperPluginManegerFactory::class
        ],
    ],
    'view_helpers' => [
        'aliases' => [
        ],
        'invokables' => [
        ],
        'factories'  => [
        ],
    ]
];

$confiProviderForm = (new \Zend\Form\ConfigProvider())->__invoke();
return Zend\Stdlib\ArrayUtils::merge($confiProviderForm, $forms);