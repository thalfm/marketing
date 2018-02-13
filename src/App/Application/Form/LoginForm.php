<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 07/01/2018
 * Time: 17:15
 */

namespace App\Application\Form;

use Zend\Form\Element\Button;
use Zend\Form\Element\Password;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class LoginForm extends Form
{

    public function __construct($name = 'login', array $options = [])
    {
        parent::__construct($name, $options);

        $this->add([
            'name' => 'email',
            'type' => Text::class,
            'options' => [
                'label' => 'E-mail: '
            ],
            'attributes' => [
                'id' => 'email',
                'type' => 'email'
            ]
        ]);

        $this->add([
            'name' => 'password',
            'type' => Password::class,
            'options' => [
                'label' => 'Senha'
            ],
            'attributes' => [
                'id' => 'password',
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Button::class,
            'attributes' => [
                'type' => 'submit'
            ]
        ]);
    }
}