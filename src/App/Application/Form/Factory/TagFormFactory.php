<?php

namespace App\Application\Form\Factory;

use App\Application\Form\TagForm;
use App\Application\InputFilter\TagInputFilter;
use App\Domain\Entity\Tag;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\ClassMethods;

class TagFormFactory
{
    public function __invoke(ContainerInterface $container) : TagForm
    {
        $form = new TagForm();
        $form->setHydrator(new ClassMethods());
        $form->setObject(new Tag());
        $form->setInputFilter(new TagInputFilter());
        return $form;
    }

}