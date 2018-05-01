<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 01/05/2018
 * Time: 13:58
 */

namespace App\Application\Action\Customer;


use App\Application\Form\CustomerForm;
use App\Application\Form\HttpMethodElement;
use App\Domain\Entity\Customer;
use App\Domain\Persistence\CustomerRepositoryInterface;
use App\Domain\Persistence\TagRepositoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Flash\FlashMessagesInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\Form;

abstract class CustomerAbstractAction
{
    const MSG_UPDATE_SUCCESS = 'Contato atualizado com sucesso!';
    const MSG_CREATE_SUCCESS = 'Contato cadastrado com sucesso!';
    const MSG_DELETE_SUCCESS = 'Contato deletado com sucesso!';

    /**
     * @var TemplateRendererInterface
     */
    private $template;
    /**
     * @var TagRepositoryInterface
     */
    private $repository;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var CustomerForm form
     */
    private $form;

    public function __construct(
        CustomerRepositoryInterface $repository,
        TemplateRendererInterface $template,
        RouterInterface $router,
        CustomerForm $form
    ){
        $this->template = $template;
        $this->repository = $repository;
        $this->router = $router;
        $this->form = $form;
    }

    /**
     * @return TemplateRendererInterface
     */
    public function getTemplate(): TemplateRendererInterface
    {
        return $this->template;
    }

    /**
     * @return CustomerRepositoryInterface
     */
    public function getRepository(): CustomerRepositoryInterface
    {
        return $this->repository;
    }

    /**
     * @return RouterInterface
     */
    public function getRouter(): RouterInterface
    {
        return $this->router;
    }

    /**
     * @return CustomerForm
     */
    public function getForm(): CustomerForm
    {
        return $this->form;
    }

    /**
     * @param ServerRequestInterface $request
     */
    protected function getEntityBy(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $entity = $this->repository->find($id);

        return $entity;
    }

    /**
     * @param Customer $entity
     * @param HttpMethodElement $element
     */
    protected function bindFormBy(Customer $entity, HttpMethodElement $element)
    {
        $this->form->add($element);
        $this->form->bind($entity);
    }

    /**
     * @return HtmlResponse
     */
    protected function formResponse(string $template): HtmlResponse
    {
        return new HtmlResponse($this->template->render("app::{$template}", [
            'form' => $this->form
        ]));
    }

    protected function verifyMethod(ServerRequestInterface $request, array $methods): bool
    {
        if (in_array($request->getMethod(), $methods)) {
            return true;
        }

        return false;
    }

    /**
     * @param ServerRequestInterface $request
     * @return Form
     */
    protected function rawDataForm(ServerRequestInterface $request): Form
    {
        $dataRaw = $request->getParsedBody();
        $this->form->setData($dataRaw);

        return $this->form;
    }

    /**
     * @param ServerRequestInterface $request
     * @return bool
     */
    protected function isFormValid(ServerRequestInterface $request): bool
    {
        $dataRaw = $request->getParsedBody();
        $this->form->setData($dataRaw);

        if (!$this->form->isValid()) {
            return false;
        }

        return true;
    }

    /**
     * @param string $uri
     * @return RedirectResponse
     */
    protected function redirectPost(string $uri): RedirectResponse
    {
        $uri = $this->router->generateUri($uri);
        return new RedirectResponse($uri);
    }

    /**
     * @param ServerRequestInterface $request
     * @return FlashMessagesInterface
     */
    protected function messageSuccess(ServerRequestInterface $request, string $message): FlashMessagesInterface
    {
        /** @var FlashMessagesInterface $flashMessage */
        $flashMessage = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
        $flashMessage->flash('success', $message);

        return $flashMessage;
    }

    /**
     * @return bool
     */
    abstract protected function formPersiste(Customer $customer): bool;
}