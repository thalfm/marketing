<?php

namespace App\Application\Action;

use App\Domain\Entity\Cliente;
use App\Domain\Entity\Customer;
use App\Domain\Entity\Endereco;
use App\Domain\Persistence\CustomerRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Plates\PlatesRenderer;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Expressive\ZendView\ZendViewRenderer;

class TestePageAction implements ServerMiddlewareInterface
{
    private $router;

    private $template;
    /**
     * @var EntityManager
     */
    private $maneger;
    /**
     * @var CustomerRepositoryInterface
     */
    private $repository;

    public function __construct(CustomerRepositoryInterface $repository, Router\RouterInterface $router, Template\TemplateRendererInterface $template = null)
    {
        $this->router = $router;
        $this->template = $template;
        $this->repository = $repository;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if (!$this->template) {
            return new JsonResponse([
                'welcome' => 'Congratulations! You have installed the zend-expressive skeleton application.',
                'docsUrl' => 'https://docs.zendframework.com/zend-expressive/',
            ]);
        }

        $customer = (new Customer())
            ->setName("thales")
            ->setEmail("thalfm@gmail.com");

        $this->repository->create($customer);

        $customers = $this->repository->findAll();

        return new HtmlResponse($this->template->render('app::teste', [
            'data' => 'Minha primeira aplicação',
            'customers' => $customers
        ]));
    }
}
