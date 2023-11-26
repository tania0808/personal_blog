<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\ContactForm;
use App\Core\Controller;
use App\Core\Exception\MailNotSentException;
use App\Core\FormValidator\ContactFormValidator;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Core\Service\EmailSender;
use App\Models\Post;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;

class AdminController extends Controller {

    private UserRepository $userRepository;
    private PostRepository $postRepository;
    private CommentRepository $commentRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
        $this->userRepository = new UserRepository();
        $this->commentRepository = new CommentRepository();
    }
    public function index()
    {
        $this->setLayout('admin');
        $posts = $this->postRepository->getAll();
        $authorIds = array_values(
            array_unique(
                array_map(
                    fn (Post $post) => $post->getAuthorId(),
                    $posts
                )
            )
        );
        $authors = $this->userRepository->getByIds($authorIds);
        return $this->render('admin/posts', ['posts' => $posts, 'authors' => $authors]);
    }

    public function delete(Request $request, Response $response)
    {
        if($this->postRepository->delete($request->routeParams['id'])) {
            $this->handleSuccessRedirect($response, '/admin/posts', 'The post was successfully deleted!');
        }

        Application::$app->session->setFlash('error', "An error occured !");
        Application::$app->response->redirect("/admin/posts");
        exit();
    }

    public function approve(Request $request, Response $response)
    {
        if($this->postRepository->approve($request->routeParams['id'], Application::$app->user->getId())) {
            $this->handleSuccessRedirect($response, '/admin/posts', 'The post was approved!');
        }

        Application::$app->session->setFlash('error', "An error occured !");
        Application::$app->response->redirect("/admin/posts");
        exit();
    }

    public function disapprove(Request $request, Response $response)
    {
        if($this->postRepository->disapprove($request->routeParams['id'], Application::$app->user->getId())) {
            $this->handleSuccessRedirect($response, '/admin/posts', 'The post was disapproved!');
        }

        Application::$app->session->setFlash('error', "An error occured !");
        Application::$app->response->redirect("/admin/posts");
        exit();
    }
}