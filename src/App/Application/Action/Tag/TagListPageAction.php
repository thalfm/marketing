<?php

namespace App\Application\Action\Tag;

use App\Domain\Persistence\TagRepositoryInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Template;

class TagListPageAction implements ServerMiddlewareInterface
{
    private $template;
    /**
     * @var TagRepositoryInterface
     */
    private $repository;

    public function __construct(
        TagRepositoryInterface $repository,
        Template\TemplateRendererInterface $template)
    {
        $this->template = $template;
        $this->repository = $repository;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $tags = $this->repository->findAll();
        $flashMessage = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
        $message = $flashMessage->getFlash('success');
        return new HtmlResponse($this->template->render("app::tag/list",[
            'tags'=> $tags,
            'message'=> $message
        ]));

    }
}
