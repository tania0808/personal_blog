<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\FormValidator\PostFormValidator;
use App\Core\ImageUpload;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\Post;
use App\Repositories\PostRepository;

class PostController extends Controller {

    private readonly PostRepository $postRepository;

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['edit']));
        $this->postRepository = new PostRepository();
    }


    public function index()
    {
        $posts = $this->postRepository->getAll();

        return $this->render('post/posts', [
            'posts' => $posts
        ]);
    }

    public function store(Request $request, Response $response)
    {
        $data = $request->getBody();
        $post = new Post();
        $post->loadData($data);
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
        return $this->render('post/newPost', ['post' => $post, 'errors' => $postFormValidator->getErrors()]);
    }

    public function show(Request $request) {
        $post = $this->postRepository->getById($request->routeParams['id']);

        return $this->render('post/singlePost', ['post' => $post]);
    }

    public function edit(Request $request) {
        $post = $this->postRepository->getById($request->routeParams['id']);

        $this->guardAgainstNotAuthorizedUser($post);

        if ($request->isPost()) {
            return $this->processEditForm($request, $post);
        }

        return $this->render('post/editPost', ['post' => $post, 'errors' => []]);
    }

    private function processEditForm(Request $request, $post)
    {
        $newPost = new Post();
        $requestPostFields = $request->getBody();
        $newPost->loadData($request->getBody());
        $postFormValidator = new PostFormValidator();

        if(!empty($_FILES['image_name']['name'])) {
            $requestPostFields['image_name'] =  $this->uploadNewImage($requestPostFields,$post);
        }

        if ($postFormValidator->validate($request) && $this->postRepository->update($post->id, $requestPostFields)) {
            Application::$app->response->redirect("/posts/$post->id");
        }
        return $this->render("post/editPost", ['post' => $newPost, 'errors' => $postFormValidator->getErrors()]);
    }

    private function uploadNewImage($request,$post)
    {
        $imageUpload = new ImageUpload($_FILES['image_name']);
        $request['image_name'] = $imageUpload->image_name;
        $imageUpload->moveFile();

        if(!empty($post->image_name)) {
            unlink($imageUpload->uploads_folder . $post->image_name);
        }

        return $imageUpload->image_name;
    }

    private function guardAgainstNotAuthorizedUser($post): void
    {
        if(Application::$app->session->get('user') === $post->author_id) {
            return;
        }

        Application::$app->session->setFlash('error', "You don't have the access to this page !");
        Application::$app->response->redirect("/posts/$post->id");
        exit();
    }
}