<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\ContactForm;
use App\Models\ImageUpload;
use App\Models\Post;
use App\Models\User;
use App\Repositories\PostRepository;

class PostController extends Controller {

    private PostRepository $postRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
    }

    public function index()
    {
        $posts = $this->postRepository->all();

        return $this->render('posts', [
            'posts' => $posts
        ]);
    }

    public function store(Request $request, Response $response)
    {
        $post = new Post();
        $post->setUser(Application::$app->user->getId());

        if ($request->isPost()) {
            $post->loadData($request->getBody());
            if(!empty($_FILES['image_name']['name'])) {
                $imageUpload = new ImageUpload($_FILES['image_name']);
                $post->setImage($imageUpload->image_name);
            }

            if ($post->validate() && $post->save()) {
                if(!empty($_FILES['image_name']['name'])) {
                    $imageUpload->moveFile();
                }
                Application::$app->session->setFlash('success', 'Your post was successfully created!');
                Application::$app->response->redirect('/');
                exit();
            }
        }

        return $this->render('newPost', ['model' => $post]);
    }

    public function show(Request $request) {
        $post = $this->postRepository->getOne($request->routeParams['id'])[0];
        return $this->render('singlePost', ['post' => $post]);
    }

    public function edit(Request $request) {
        $post = $this->postRepository->getOne($request->routeParams['id'])[0];
        return $this->render('singlePost', ['post' => $post]);
    }
}