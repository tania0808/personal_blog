<?php

namespace App\Core;

use App\Core\Middlewares\BaseMiddleware;
use JetBrains\PhpStorm\NoReturn;

class Controller
{
    public string $layout = 'main';
    public string $action = '';

    /** @var array BaseMiddleware */
    protected array $middlewares = [];
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    protected function handleSuccessRedirect(Response $response, ?string $location = '/', ?string $message = 'Your post was successfully created!'): void
    {
        Application::$app->session->setFlash('success', $message);
        $response->redirect($location);
        exit();
    }

}