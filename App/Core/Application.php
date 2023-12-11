<?php

namespace App\Core;

use App\Models\User;
use App\Repositories\UserRepository;
use Exception;

class Application
{
    public static string $ROOT_DIR;
    public string $layout = 'main';
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public View $view;
    public Database $db;

    public ?User $user;

    public static Application $app;
    public ?Controller $controller = null;

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->view = new View();
        $this->router = new Router($this->request, $this->response);

        $this->db = new Database($config['db']);

        $userSession = $this->session->get('user');

        if (is_array($userSession) && isset($userSession['id'])) {
            $primaryKeyValue = $userSession['id'];
        } else {
            $primaryKeyValue = null; // or some default value
        }

        if ($primaryKeyValue) {
            $this->user = (new UserRepository())->getById($primaryKeyValue);
        } else {
            $this->user = null;
        }
    }

    public static function isGuest(): bool
    {
        return !self::$app->user;
    }
    public static function isAdmin(): bool
    {
        if (!self::$app->user) {
            return false;
        }

        return self::$app->user->getIs_admin();
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve();
        } catch (Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    public function login(User $user): bool
    {
        $this->user = $user;
        $this->session->set('user', ['id' => $user->getId(), 'is_admin' => $user->getIs_admin()]);
        return true;
    }

    public function logout(): void
    {
        $this->user = null;
        $this->session->remove('user');
    }
}
