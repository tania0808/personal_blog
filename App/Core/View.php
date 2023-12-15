<?php

namespace App\Core;

class View
{
    public string $title = '';

    public function renderView($view, $params = []): array|false|string
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent(): false|string
    {
        $layout = Application::$app->layout;
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/App/Views/layout/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params): false|string
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/App/Views/$view.php";
        return ob_get_clean();
    }
}
