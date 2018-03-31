<?php
/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Application\Action\HomePageAction::class, 'home');
 * $app->post('/album', App\Action\AlbumCreateAction::class, 'album.create');
 * $app->put('/album/:id', App\Action\AlbumUpdateAction::class, 'album.put');
 * $app->patch('/album/:id', App\Action\AlbumUpdateAction::class, 'album.patch');
 * $app->delete('/album/:id', App\Action\AlbumDeleteAction::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Action\ContactAction::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */
/** @var \Zend\Expressive\Application $app */
$app->get('/', \App\Application\Action\HomePageAction::class, 'home');
$app->get('/teste', \App\Application\Action\TestePageAction::class, 'teste');
$app->get('/api/ping', \App\Application\Action\PingAction::class, 'api.ping');

/** Custumer */
$app->get('/admin/customers', \App\Application\Action\Customer\CustomerListPageAction::class, 'customer.list');
$app->route('/admin/customer/create', \App\Application\Action\Customer\CustomerCreatePageAction::class, ['GET', 'POST'], 'customer.create');
$app->route('/admin/customer/update/{id}', \App\Application\Action\Customer\CustomerUpdatePageAction::class, ['GET', 'POST', 'PUT'], 'customer.update');
$app->route('/admin/customer/delete/{id}', \App\Application\Action\Customer\CustomerDeletePageAction::class, ['GET', 'POST', 'DELETE'], 'customer.delete');

/** Tags */
$app->get('/admin/tags', \App\Application\Action\Tag\TagListPageAction::class, 'tag.list');
$app->route('/admin/tags/create', \App\Application\Action\Tag\TagCreatePageAction::class, ['GET', 'POST'], 'tag.create');
$app->route('/admin/tags/update/{id}', \App\Application\Action\Tag\TagUpdatePageAction::class, ['GET', 'POST', 'PUT'], 'tag.update');
$app->route('/admin/tags/delete/{id}', \App\Application\Action\Tag\TagDeletePageAction::class, ['GET', 'POST', 'DELETE'], 'tag.delete');

/** Campanha */
$app->get('/admin/campaigns', \App\Application\Action\Campaign\CampaignListPageAction::class, 'campaign.list');
$app->route('/admin/campaign/create', \App\Application\Action\Campaign\CampaignCreatePageAction::class, ['GET', 'POST'], 'campaign.create');
$app->route('/admin/campaign/update/{id}', \App\Application\Action\Campaign\CampaignUpdatePageAction::class, ['GET', 'POST', 'PUT'], 'campaign.update');
$app->route('/admin/campaign/delete/{id}', \App\Application\Action\Campaign\CampaignDeletePageAction::class, ['GET', 'POST', 'DELETE'], 'campaign.delete');
$app->route('/admin/campaign/sender', \App\Application\Action\Campaign\CampaignSenderPageAction::class, ['GET', 'POST'], 'campaign.sender');


/** Login */
$app->route('/auth/login',
    [
        \App\Application\Action\LoginPageHandle::class,
        \Zend\Expressive\Authentication\AuthenticationMiddleware::class,
    ],
    ['GET', 'POST'],
    'auth.login');
$app->get('/auth/logout', \App\Application\Action\LogoutHandle::class, 'auth.logout');