<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 06/12/2017
 * Time: 14:25
 */

namespace App\Application\Action\Customer;


use App\Application\Form\CustomerForm;
use App\Application\Form\HttpMethodElement;
use App\Domain\Entity\Customer;
use App\Domain\Persistence\CustomerRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Flash\FlashMessagesInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class CustomerDeletePageAction
{
    private $router;

    private $template;
    /**
     * @var CustomerRepositoryInterface
     */
    private $repository;
    /**
     * @var CustomerForm
     */
    private $customerForm;

    /**
     * @var Customer
     */
    private $entity;

    /**
     * CustomerDeletePageAction constructor.
     * @param CustomerRepositoryInterface $repository
     * @param RouterInterface $router
     * @param TemplateRendererInterface|null $template
     * @param CustomerForm $customerForm
     */
    public function __construct(
        CustomerRepositoryInterface $repository,
        RouterInterface $router,
        TemplateRendererInterface $template = null,
        CustomerForm $customerForm
    )
    {
        $this->router = $router;
        $this->template = $template;
        $this->repository = $repository;
        $this->customerForm = $customerForm;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return HtmlResponse|RedirectResponse
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $this->getCustomerBy($request);
        return $this->customerDelete($request);
    }

    /**
     * @param ServerRequestInterface $request
     */
    private function getCustomerBy(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $this->entity = $this->repository->find($id);
        $this->customerForm->add(new HttpMethodElement('DELETE'));
        $this->customerForm->bind($this->entity);
    }

    /**
     * @return HtmlResponse
     */
    private function formDeleteResponse()
    {
        return new HtmlResponse($this->template->render("app::customer/delete", [
            'form' => $this->customerForm
        ]));
    }

    /**
     * @param ServerRequestInterface $request
     * @return HtmlResponse|RedirectResponse
     */
    private function customerDelete(ServerRequestInterface $request)
    {
        if ($request->getMethod() != 'DELETE' && $request->getMethod() != 'POST') {
            return $this->formDeleteResponse();
        }

        $this->repository->remove($this->entity);

        /** @var FlashMessagesInterface $flashMessage */
        $flashMessage = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
        $flashMessage->flash('success', 'Contato removido com sucesso!');

        $uri = $this->router->generateUri('customer.list');
        return new RedirectResponse($uri);
    }
}