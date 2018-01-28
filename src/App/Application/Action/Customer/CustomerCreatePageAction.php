<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 06/12/2017
 * Time: 14:25
 */

namespace App\Application\Action\Customer;


use App\Application\Form\CustomerForm;
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

class CustomerCreatePageAction
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
     * CustomerCreatePageAction constructor.
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
        return $this->customerCreate($request);
    }

    /**
     * @return HtmlResponse
     */
    private function formCreateResponse()
    {
        return new HtmlResponse($this->template->render("app::customer/create", [
            'form' => $this->customerForm
        ]));
    }

    /**
     * @param ServerRequestInterface $request
     * @return HtmlResponse|RedirectResponse
     */
    private function customerCreate(ServerRequestInterface $request)
    {
        if ($request->getMethod() != 'POST') {
            return $this->formCreateResponse();
        }

        $dataRaw = $request->getParsedBody();
        $this->customerForm->setData($dataRaw);

        if (!$this->customerForm->isValid()) {
            return $this->formCreateResponse();
        }

        $entity = $this->customerForm->getData();
        $this->repository->create($entity);

        /** @var FlashMessagesInterface $flashMessage */
        $flashMessage = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
        $flashMessage->flash('success', 'Contato cadastrado com sucesso!');

        $uri = $this->router->generateUri('customer.list');
        return new RedirectResponse($uri);
    }
}