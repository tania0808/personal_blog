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
    public function setLayout($layout): void
    {
        $this->layout = $layout;
    }
    public function render($view, $params = []): array|false|string
    {
        return Application::$app->view->renderView($view, $params);
    }

    #[NoReturn] protected function handleSuccessRedirect(
        Response $response,
        ?string $location = '/',
        ?string $message = 'Your post was successfully created!'
    ): void {
        Application::$app->session->setFlash('success', $message);
        $response->redirect($location);
        exit();
    }
    #[NoReturn] protected function handleErrorRedirect(
        Response $response,
        ?string $location = '/',
        ?string $message = "An error occured !"
    ): void {
        Application::$app->session->setFlash('error', $message);
        $response->redirect($location);
        exit();
    }

    #[NoReturn] protected function redirect(
        Response $response,
        $success,
        $successRedirection,
        $successMessage,
        $errorRedirection
    ): void {
        if ($success) {
            $this->handleSuccessRedirect($response, $successRedirection, $successMessage);
        } else {
            $this->handleErrorRedirect($response, $errorRedirection);
        }
    }

    protected function guardAgainstNotAuthenticatedUser(Response $response): void
    {
        if (!Application::isGuest()) {
            return;
        }

        $this->handleErrorRedirect($response, "/", "You must be authenticated to access to this page !");
    }

    protected function guardAgainstNotAdminUser(Response $response): void
    {
        if (Application::isAdmin()) {
            return;
        }

        $this->handleErrorRedirect($response, "/", "You don't have the access to this page !");
    }
}
