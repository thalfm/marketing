<?php
/**
 * @see       https://github.com/zendframework/zend-expressive-twigrenderer for the canonical source repository
 * @copyright Copyright (c) 2015-2017 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-expressive-twigrenderer/blob/master/LICENSE.md New BSD License
 */

namespace App\Infrastructure\View\Twig;

use Twig_Environment as TwigEnvironment;

class TwigRenderer extends \Zend\Expressive\Twig\TwigRenderer
{

    /**
     * @return TwigEnvironment
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
