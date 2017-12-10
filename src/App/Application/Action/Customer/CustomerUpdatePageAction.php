<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 06/12/2017
 * Time: 14:25
 */

namespace App\Application\Action\Customer;


use App\Domain\Entity\Customer;
use App\Domain\Persistence\CustomerRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use function var_dump;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Flash\FlashMessagesInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class CustomerUpdatePageAction
{
    private $router;

    private $template;
    /**
     * @var CustomerRepositoryInterface
     */
    private $repository;

    public function __construct(CustomerRepositoryInterface $repository, RouterInterface $router, TemplateRendererInterface $template)
    {
        $this->router = $router;
        $this->template = $template;
        $this->repository = $repository;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return HtmlResponse|RedirectResponse
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $id = $request->getAttribute('id');
        /** @var Customer $entity */
        $entity = $this->repository->find($id);
        if ($request->getMethod() == 'PUT' || $request->getMethod() == 'POST'){
            /** @var FlashMessagesInterface $flashMessage */
            $flashMessage = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
            $data = $request->getParsedBody();
            $entity->setName($data['name']);
            $entity->setEmail($data['email']);
            $this->repository->update($entity);
            $flashMessage->flash('success', 'Contato atualizado com sucesso!');
            $uri = $this->router->generateUri('customer.list');
            return new RedirectResponse($uri);
        }

        return new HtmlResponse($this->template->render('app::customer/update', [
            'customer' => $entity
        ]));
    }
}