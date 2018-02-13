<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 12/02/2018
 * Time: 21:51
 */

namespace App\Application\Middleware;


use App\Domain\Service\AuthInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;

class AuthenticationMiddleware
{
    /**
     * @var AuthInterface
     */
    private $authService;
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router, AuthInterface $authService)
    {
        $this->authService = $authService;
        $this->router = $router;
    }
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {  //echo 'authentication';
        $routeResult = $request->getAttribute('Zend\Expressive\Router\RouteResult');
        $routeName   = $routeResult?? '' ??$routeResult->getMatchedRouteName();
        if(!$this->authService->isAuth() && $routeName!='auth.login'){
            $uri = $this->router->generateUri('auth.login');
            return new RedirectResponse($uri);
        }
        return $next($request,$response);
    }
}