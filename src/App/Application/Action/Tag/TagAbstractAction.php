<?php
/**
 * Created by PhpStorm.
 * User: thales
 * Date: 01/05/2018
 * Time: 13:17
 */

namespace App\Application\Action\Tag;


use App\Application\Form\HttpMethodElement;
use App\Application\Form\TagForm;
use App\Domain\Entity\Tag;
use App\Domain\Persistence\TagRepositoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Flash\FlashMessagesInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\Form;

abstract class TagAbstractAction
{
    const MSG_UPDATE_SUCCESS = 'Tag atualizado com sucesso!';
    const MSG_CREATE_SUCCESS = 'Tag cadastrada com sucesso!';
    const MSG_DELETE_SUCCESS = 'Tag deletada com sucesso!';

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
     * @var tagForm
     */
    private $form;

    public function __construct(
        TagRepositoryInterface $repository,
        TemplateRendererInterface $template,
        RouterInterface $router,
        TagForm $form
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
     * @return TagRepositoryInterface
     */
    public function getRepository(): TagRepositoryInterface
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
     * @return TagForm
     */
    public function getForm(): TagForm
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
     * @param Tag $entity
     * @param HttpMethodElement $element
     */
    protected function bindFormBy(Tag $entity, HttpMethodElement $element)
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
    abstract protected function formPersiste(Tag $tag): bool;
}