<?php

namespace App\Application\Action\Customer;

use App\Domain\Persistence\CustomerRepositoryInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;


class CustomerListPageAction implements ServerMiddlewareInterface
{
    private $router;

    private $template;
    /**
     * @var CustomerRepositoryInterface
     */
    private $repository;

    public function __construct(CustomerRepositoryInterface $repository, RouterInterface $router, TemplateRendererInterface $template = null)
    {
        $this->router = $router;
        $this->template = $template;
        $this->repository = $repository;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $customers = $this->repository->findAll();

        return new HtmlResponse($this->template->render('app::customer/list', [
            'customers' => $customers
        ]));
    }
}
