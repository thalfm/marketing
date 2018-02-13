<?php

namespace App\Application\Action;

use App\Application\Form\LoginForm;
use App\Domain\Service\AuthInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Authentication\UserInterface;
use Zend\Expressive\Router;
use Zend\Expressive\Session\SessionMiddleware;
use Zend\Expressive\Template;

class LoginPageHandle implements MiddlewareInterface
{
    private $router;

    private $template;
    /**
     * @var LoginForm
     */
    private $form;
    /**
     * @var AuthInterface
     */
    private $authService;

    public function __construct(
        Router\RouterInterface $router,
        Template\TemplateRendererInterface $template,
        LoginForm $form)
    {
        $this->router = $router;
        $this->template = $template;
        $this->form = $form;
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
            $uri = $this->router->generateUri('customer.list');
            return new RedirectResponse($uri);
        }

        $renderParams = [
            'form' => $this->form
        ];
        if($request->getMethod() == 'POST'){
            $data = $request->getParsedBody();
            $this->form->setData($data);
            if($this->form->isValid()){
                $response = $delegate->process($request);

                if ($response->getStatusCode() != 301) {
                    $uri = $this->router->generateUri('customer.list');
                    return new RedirectResponse($uri);
                }

                $renderParams['message'] = 'Login e/ou senha inválidos :(';
                $renderParams['messageType'] = 'error';
            }
        }
        return new HtmlResponse($this->template->render('app::login',$renderParams));
    }
}
