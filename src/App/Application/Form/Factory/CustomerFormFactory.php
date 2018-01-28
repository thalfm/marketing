<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 28/01/2018
 * Time: 11:39
 */

namespace App\Application\Form\Factory;


use App\Application\Form\CustomerForm;
use App\Application\InputFilter\CustomerInputFilter;
use App\Domain\Entity\Customer;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\ClassMethods;

class CustomerFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $customerForm = new CustomerForm();
        $customerForm->setObject(new Customer());
        $customerForm->setInputFilter(new CustomerInputFilter());
        $customerForm->setHydrator(new ClassMethods());

        return $customerForm;
    }
}