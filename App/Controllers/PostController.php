<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\FormValidator\PostFormValidator;
use App\Core\Request;
use App\Core\Response;
use App\Models\ImageUpload;
use App\Models\Post;
use App\Repositories\PostRepository;

class PostController extends Controller {

    private readonly PostRepository $postRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
    }

    public function index()
    {
        $posts = $this->postRepository->getAll();

        return $this->render('posts', [
            'posts' => $posts
        ]);
    }

    public function store(Request $request, Response $response)
    {
        $data = $request->getBody();
        $data['author_id'] = Application::$app->user->getId();
        $postFormValidator = new PostFormValidator();

        if ($request->isPost()) {

            if(!empty($_FILES['image_name']['name'])) {
                $imageUpload = new ImageUpload($_FILES['image_name']);
                $data['image_name'] = $imageUpload->image_name;
            }

            if ($postFormValidator->validate($request) && $this->postRepository->create($data)) {
                if(!empty($_FILES['image_name']['name'])) {
                    $imageUpload->moveFile();
                }
                Application::$app->session->setFlash('success', 'Your post was successfully created!');
                Application::$app->response->redirect('/');
                exit();
            }
        }

        return $this->render('newPost', ['model' => new Post(), 'errors' => $postFormValidator->getErrors()]);
    }

    public function show(Request $request) {
        $post = $this->postRepository->getById($request->routeParams['id']);
        return $this->render('singlePost', ['post' => $post]);
    }

    public function edit(Request $request) {
        $post = $this->postRepository->getById($request->routeParams['id']);

        if ($request->isPost()) {
            $postFormValidator = new PostFormValidator();

            if (!$postFormValidator->validate($request)) {
                return $this->render('editPost', ['post' => $post, 'errors' => $postFormValidator->getErrors()]);
            }
        }

        return $this->render('editPost', ['post' => $post, 'errors' => []]);
    }
}