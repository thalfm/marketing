<?php

namespace App\Action;

use App\Entity\Cliente;
use App\Entity\Endereco;
use Doctrine\ORM\EntityManager;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Expressive\Plates\PlatesRenderer;
use Zend\Expressive\Twig\TwigRenderer;
use Zend\Expressive\ZendView\ZendViewRenderer;

class TestePageAction implements ServerMiddlewareInterface
{
    private $router;

    private $template;
    /**
     * @var EntityManager
     */
    private $maneger;

    public function __construct(EntityManager $maneger, Router\RouterInterface $router, Template\TemplateRendererInterface $template = null)
    {
        $this->router   = $router;
        $this->template = $template;
        $this->maneger = $maneger;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if (! $this->template) {
            return new JsonResponse([
                'welcome' => 'Congratulations! You have installed the zend-expressive skeleton application.',
                'docsUrl' => 'https://docs.zendframework.com/zend-expressive/',
            ]);
        }

        $cliente = (new Cliente())
            ->setNome('teste')
            ->setCpf(12345678912)
            ->setEmail('teste@teste.com');

        $this->maneger->persist($cliente);

        $endereco = (new Endereco())
            ->setCep(700000)
            ->setCidade('Brasilia')
            ->setEstado('DF')
            ->setLogradouro('Jardim Botânico')
            ->setCliente($cliente);

        $this->maneger->persist($endereco);
        $this->maneger->flush();

        $clientes = $this->maneger->getRepository(Cliente::class)->findAll();

        return new HtmlResponse($this->template->render('app::teste', [
            'data' => 'Minha primeira aplicação',
            'clientes' => $clientes
        ]));
    }
}
