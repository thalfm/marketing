<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 06/11/2017
 * Time: 13:02
 */
return [
    'doctrine'=>[
        'connection'=>[
            'orm_default'=>[
                'driverClass'=>'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params'=>[
                    'host'=>'localhost',
                    'port'=>'3306',
                    'user'=>'root',
                    'password'=>'',
                    'dbname'=>'teste',
                    'driverOptions'=>[
                        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
                    ]
                ]
            ]
        ],
        'driver'=>[
            'App_driver'=>[
                'class'=>'Doctrine\ORM\Mapping\Driver\YamlDriver',
                'cache'=>'array',
                'paths'=>[__DIR__ . '/../../src/App/Infrastructure/Persistence/Doctrine/ORM']
            ],
            'orm_default'=>[
                'drivers'=>[
                    'App\Domain\Entity'=>'App_driver'
                ]
            ]
        ],

        'fixtures' => [
            'MyFixture' => __DIR__ . '/../../src/App/Infrastructure/Persistence/Doctrine/DataFixture'
        ]
    ]
];