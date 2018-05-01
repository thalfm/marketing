<?php

namespace App\Application\Action\Campaign;

use App\Application\Form\CampaignForm;
use App\Domain\Entity\Campaign;
use Zend\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Flash\FlashMessagesInterface;
use Zend\Expressive\Router\RouterInterface;
use App\Domain\Persistence\CampaignRepositoryInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use App\Application\Form\HttpMethodElement;


class CampaignDeletePageAction extends CampaignAbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $entity = $this->getEntityBy($request);
        $this->bindFormBy($entity, new HttpMethodElement('DELETE'));

        if (!$this->verifyMethod($request, ['POST', 'DELETE'])) {
            return $this->formResponse('campaign/delete');
        }

        $this->formPersiste($entity);
        $this->messageSuccess($request, self::MSG_DELETE_SUCCESS);

        return $this->redirectPost('campaign.list');
    }

    /**
     * @return bool
     */
    protected function formPersiste(Campaign $campaign): bool
    {
        $this->getRepository()->remove($campaign);

        return true;
    }
}
