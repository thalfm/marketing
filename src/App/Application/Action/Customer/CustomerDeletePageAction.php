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

class CustomerDeletePageAction extends CustomerAbstractAction
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
        $this->bindFormBy($entity, new HttpMethodElement('DELETE'));

        if (!$this->verifyMethod($request, ['POST', 'DELETE'])) {
            return $this->formResponse('customer/delete');
        }

        $this->formPersiste($entity);
        $this->messageSuccess($request, self::MSG_DELETE_SUCCESS);

        return $this->redirectPost('customer.list');
    }

    /**
     * @return bool
     */
    protected function formPersiste(Customer $customer): bool
    {
        $this->getRepository()->remove($customer);

        return true;
    }
}