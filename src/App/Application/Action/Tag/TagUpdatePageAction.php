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
use Zend\Form\Form;


class TagUpdatePageAction extends TagAbstractAction
{


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return HtmlResponse|RedirectResponse
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {

        $entity = $this->getEntityBy($request);
        $this->bindFormBy($entity, new HttpMethodElement('PUT'));

        if (!$this->verifyMethod($request, ['POST', 'PUT'])) {
            return $this->formResponse('tag/update');
        }

        $this->rawDataForm($request);
        if (!$this->isFormValid($request)) {
            return $this->formResponse('tag/update');
        }

        /** @var Tag $tag */
        $tag = $this->getForm()->getData();
        $this->formPersiste($tag);
        $this->messageSuccess($request, self::MSG_UPDATE_SUCCESS);

        return $this->redirectPost('tag.list');
    }


    /**
     * @return bool
     */
    protected function formPersiste(Tag $tag): bool
    {
        $this->getRepository()->update($tag);

        return true;
    }
}
