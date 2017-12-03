<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 06/11/2017
 * Time: 13:02
 */
return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => Doctrine\DBAL\Driver\PDOMySql\Driver::class,
                'host' => '127.0.0.1',
                'port' => '3306',
                'user' => 'root',
                'password' => '',
                'dbname' => 'teste',
                'driverOptions' => [
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
                ]
            ]
        ],
        'driver' => [
            'App_driver' => [
                'class' => Doctrine\ORM\Mapping\Driver\YamlDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../../src/App/Infrastructure/Persistence/Doctrine/ORM']
                //'class' => Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                //'paths' => [__DIR__ . '/../../src/App/Domain/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    'App\Domain\Entity' => 'App_driver'
                ]
            ]
        ]
    ]
];