<?php

namespace App\Core;

class Request
{
    public array $routeParams = [];
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if (!$position) {
            return $path;
        }

        return substr($path, 0, $position);
    }

    public function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet(): bool
    {
        return $this->method() === 'get';
    }
    public function isPost(): bool
    {
        return $this->method() === 'post';
    }

    public function getBody(): array
    {
        $body = [];

        if ($this->method() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = trim(filter_input(INPUT_GET, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            }
        }

        if ($this->method() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = trim(filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            }
            foreach ($_FILES as $key => $file) {
                $body[$key] = $file['name'];
            }
        }

        return $body;
    }

    public function setRouteParams(array $params): static
    {
        $this->routeParams = $params;
        return $this;
    }
}
