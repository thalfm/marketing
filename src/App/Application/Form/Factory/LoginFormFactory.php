<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 28/01/2018
 * Time: 11:39
 */

namespace App\Application\Form\Factory;


use App\Application\Form\CustomerForm;
use App\Application\Form\LoginForm;
use App\Application\InputFilter\CustomerInputFilter;
use App\Application\InputFilter\LoginInputFilter;
use App\Domain\Entity\Customer;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\ClassMethods;

class LoginFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $loginForm = new LoginForm();
        $loginForm->setInputFilter(new LoginInputFilter());

        return $loginForm;
    }
}