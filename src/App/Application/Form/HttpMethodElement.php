<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 28/01/2018
 * Time: 13:39
 */

namespace App\Application\Form;


use Zend\Form\Element\Hidden;

class HttpMethodElement extends Hidden
{
    public function __construct($value, array $options = [])
    {
        parent::__construct('_method', $options);
        $this->setValue($value);
    }
}