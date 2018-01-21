<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 07/01/2018
 * Time: 16:36
 */

namespace App\Infrastructure\View;


use Interop\Container\ContainerInterface;
use Zend\View\HelperPluginManager;
use Zend\View\Renderer\PhpRenderer;

class HelperPluginManegerFactory
{

    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        $viewHelpers = $config['view_helpers'];
        $manager = new HelperPluginManager($container, $viewHelpers);
        $phpRender = new PhpRenderer();
        $phpRender->setHelperPluginManager($manager);

        return $manager;
    }
}