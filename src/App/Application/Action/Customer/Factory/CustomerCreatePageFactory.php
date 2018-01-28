<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 23/09/2017
 * Time: 15:19
 */

namespace App\Application\Action\Customer\Factory;

use App\Application\Action\Customer\CustomerCreatePageAction;
use App\Application\Form\CustomerForm;
use App\Domain\Persistence\CustomerRepositoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class CustomerCreatePageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $router = $container->get(RouterInterface::class);
        $template = $container->get(TemplateRendererInterface::class);
        $repository = $container->get(CustomerRepositoryInterface::class);
        $customerForm = $container->get(CustomerForm::class);

        return new CustomerCreatePageAction($repository, $router, $template, $customerForm);
    }
}