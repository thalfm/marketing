<?php

use App\Application\Middleware\TwigMiddleware;
use Zend\Expressive\Helper\ServerUrlMiddleware;
use Zend\Expressive\Helper\UrlHelperMiddleware;
use Zend\Expressive\Router\Middleware\DispatchMiddleware;
use Zend\Expressive\Router\Middleware\ImplicitHeadMiddleware;
use Zend\Expressive\Router\Middleware\ImplicitOptionsMiddleware;
use Zend\Expressive\Middleware\NotFoundHandler;
use Zend\Expressive\Router\Middleware\RouteMiddleware;
use Zend\Expressive\Session\SessionMiddleware;
use Zend\Stratigility\Middleware\ErrorHandler;

/**
 * Setup middleware pipeline:
 */

// The error handler should be the first (most outer) middleware to catch
// all Exceptions.
/** @var \Zend\Expressive\Application $app */
$app->pipe(ErrorHandler::class);
$app->pipe(ServerUrlMiddleware::class);
$app->pipe(SessionMiddleware::class);

// Pipe more middleware here that you want to execute on every request:
// - bootstrapping
// - pre-conditions
// - modifications to outgoing responses
//
// Piped Middleware may be either callables or service names. Middleware may
// also be passed as an array; each item in the array must resolve to
// middleware eventually (i.e., callable or service name).
//
// Middleware can be attached to specific paths, allowing you to mix and match
// applications under a common domain.  The handlers in each middleware
// attached this way will see a URI with the MATCHED PATH SEGMENT REMOVED!!!
//
// - $app->pipe('/api', $apiMiddleware);
// - $app->pipe('/docs', $apiDocMiddleware);
// - $app->pipe('/files', $filesMiddleware);
$app->pipe('/admin', \Zend\Expressive\Authentication\AuthenticationMiddleware::class);

// Register the routing middleware in the middleware pipeline
$app->pipe(UrlHelperMiddleware::class);
$app->pipe(RouteMiddleware::class);
$app->pipe(ImplicitHeadMiddleware::class);
$app->pipe(ImplicitOptionsMiddleware::class);
$app->pipe(TwigMiddleware::class);

// Add more middleware here that needs to introspect the routing results; this
// might include:
//
// - route-based authentication
// - route-based validation
// - etc.

//$app->pipe(\Zend\Expressive\Authentication\AuthenticationMiddleware::class);
$app->pipe(\Zend\Expressive\Flash\FlashMessageMiddleware::class);
// Register the dispatch middleware in the middleware pipeline
$app->pipe(DispatchMiddleware::class);

// At this point, if no Response is return by any middleware, the
// NotFoundHandler kicks in; alternately, you can provide other fallback
// middleware to execute.
$app->pipe(NotFoundHandler::class);