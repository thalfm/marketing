<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 28/01/2018
 * Time: 12:03
 */

namespace App\Application\InputFilter;

use Zend\Filter\StringTrim;
use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;
use Zend\Validator\NotEmpty;

class LoginInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class]
            ],
            'validators' => [
                [
                    'name' => NotEmpty::class,
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'Este campo é requerido'
                        ]
                    ]
                ],
                [
                    'name' => EmailAddress::class,
                    'options' => [
                        'messages' => [
                            EmailAddress::INVALID => 'Este e-mail não é válido',
                            EmailAddress::INVALID_FORMAT => 'Este e-mail não é válido'
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => 'password',
            'required' => true,
            'validators' => [
                [
                    'name' => NotEmpty::class,
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'Este campo é requerido'
                        ]
                    ]
                ]
            ]
        ]);
    }
}