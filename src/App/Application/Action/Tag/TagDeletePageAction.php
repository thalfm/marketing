<?php

namespace App\Application\Action\Tag;

use App\Application\Form\TagForm;
use App\Domain\Entity\Tag;
use Zend\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Flash\FlashMessagesInterface;
use Zend\Expressive\Router\RouterInterface;
use App\Domain\Persistence\TagRepositoryInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use App\Application\Form\HttpMethodElement;


class TagDeletePageAction extends TagAbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {

        $entity = $this->getEntityBy($request);
        $this->bindFormBy($entity, new HttpMethodElement('DELETE'));

        if (!$this->verifyMethod($request, ['POST', 'DELETE'])) {
            return $this->formResponse('tag/delete');
        }

        $this->formPersiste($entity);
        $this->messageSuccess($request, self::MSG_DELETE_SUCCESS);

        return $this->redirectPost('tag.list');
    }

    /**
     * @return bool
     */
    protected function formPersiste(Tag $tag): bool
    {
        $this->getRepository()->remove($tag);

        return true;
    }
}
