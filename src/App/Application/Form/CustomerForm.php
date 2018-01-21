<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 07/01/2018
 * Time: 17:15
 */

namespace App\Application\Form;

use Zend\Form\Element\Button;
use Zend\Form\Element\Email;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class CustomerForm extends Form
{

    public function __construct($name = 'customer', array $options = [])
    {
        parent::__construct($name, $options);

        $this->add([
            'name' => 'id',
            'type' => Hidden::class
        ]);
        $this->add([
            'name' => 'nome',
            'type' => Text::class,
            'options' => [
                'label' => 'Nome: '
            ],
            'attributes' => [
                'id' => 'nome'
            ]
        ]);

        $this->add([
            'name' => 'email',
            'type' => Email::class,
            'options' => [
                'label' => 'E-mail: '
            ],
            'attributes' => [
                'id' => 'email'
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Button::class,
            'options' => [
                'label' => 'Incluir'
            ],
            'attributes' => [
                'type' => 'submit'
            ]
        ]);
    }
}