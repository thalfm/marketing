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
$app->get('/admin/list', \App\Application\Action\Customer\CustomerListPageAction::class, 'customer.list');
$app->route('/admin/create', \App\Application\Action\Customer\CustomerCreatePageAction::class, ['GET', 'POST'], 'customer.create');
$app->route('/admin/update/{id}', \App\Application\Action\Customer\CustomerUpdatePageAction::class, ['GET', 'POST', 'PUT'], 'customer.update');
$app->route('/admin/delete/{id}', \App\Application\Action\Customer\CustomerDeletePageAction::class, ['GET', 'POST', 'DELETE'], 'customer.delete');