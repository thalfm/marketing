<?php

namespace App\Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class TagForm extends Form
{
    public function __construct($name = 'tag', array $options = [])
    {
        parent::__construct($name, $options);


        $this->add([
            'name' => 'id',
            'type' => Element\Hidden::class
        ]);

        $this->add([
            'name' => 'name',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Nome'
            ],
            'attributes' => [
                'id' => 'name'
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Element\Button::class,
            'attributes' => [
                'type' => 'submit'
            ]
        ]);
    }
}


