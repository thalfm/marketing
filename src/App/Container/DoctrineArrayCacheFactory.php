<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 06/11/2017
 * Time: 12:59
 */

namespace App\Container;

use Doctrine\Common\Cache\ArrayCache;
use Interop\Container\ContainerInterface;

class DoctrineArrayCacheFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ArrayCache();
    }
}