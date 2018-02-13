<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 12/02/2018
 * Time: 21:54
 */

namespace App\Application\Action;


use App\Domain\Service\AuthInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Authentication\UserInterface;
use Zend\Expressive\Router;
use Zend\Expressive\Session\SessionMiddleware;

class LogoutHandle implements MiddlewareInterface
{
    private $router;
    private $authService;
    public function __construct(
        Router\RouterInterface $router
    ){
        $this->router   = $router;
    }


    /**
     * Process an incoming server request and return a response, optionally delegating
     * to the next middleware component to create the response.
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
        if ($session->has(UserInterface::class)) {
            $session->clear();
        }

        $uri = $this->router->generateUri('auth.login');
        return new RedirectResponse($uri);
    }
}