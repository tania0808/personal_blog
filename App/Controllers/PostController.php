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
        $post = $this->loadPostDataFromRequest($request);
        $postFormValidator = new PostFormValidator();
        $errors = $postFormValidator->getErrors();
        if ($request->isPost()) {
            $imageUpload = $this->handleImageUpload($post, $errors);
            if ($postFormValidator->validate($request) && empty($errors['image_name']) && $this->postRepository->create($post)) {
                $imageUpload->moveFile();
                $this->handleSuccessRedirect($response, "/posts");
            }
        }
        return $this->render('post/newPost', ['post' => $post, 'errors' => $errors]);
    }

    public function show(Request $request, Response $response) {
        $post = $this->postRepository->getById($request->routeParams['id']);

        return $this->render('post/singlePost', ['post' => $post]);
    }

    public function edit(Request $request, Response $response) {
        $existingPost = $this->postRepository->getById($request->routeParams['id']);
        $this->guardAgainstNotAuthorizedUser($existingPost);

        if ($request->isPost()) {
            $postFormValidator = new PostFormValidator();
            $errors = $postFormValidator->getErrors();
            $newPost = $this->loadPostDataFromRequest($request);
            $imageUpload = $this->handleImageUpload($newPost, $errors);

            if ($postFormValidator->validate($request) && empty($errors['image_name']) && $this->postRepository->update($existingPost->getId(), $newPost)) {
                $imageUpload->moveFile();
                $this->handleImageDelete($imageUpload, $existingPost);
                $this->handleSuccessRedirect($response, "/posts/{$existingPost->getId()}", 'Your post was successfully edited!');
            }

            return $this->render("post/editPost", ['post' => $newPost, 'errors' => $errors]);
        }

        return $this->render('post/editPost', ['post' => $existingPost, 'errors' => []]);
    }

    public function loadPostDataFromRequest(Request $request): Post
    {
        $post = new Post();
        $post->loadData($request->getBody());
        $post->setAuthorId(Application::$app->user->getId());
        return $post;
    }

    public function handleImageUpload(Post $post, array &$errors): ?ImageUpload
    {
        if(!empty($_FILES['image_name']['name'])) {
            $imageUpload = new ImageUpload($_FILES['image_name']);
            $errors['image_name'] = $imageUpload->getErrors();
            $post->setImageName($imageUpload->image_name);
            return $imageUpload;
        }
        return null;
    }

    public function handleImageDelete(?ImageUpload $imageUpload, Post $existingPost): void
    {
        if ($imageUpload && !empty($existingPost->getImageName())) {
            unlink($imageUpload->uploads_folder . $existingPost->getImageName());
        }
    }

    private function processEditForm(Request $request, $post)
    {

    }

    private function handleSuccessRedirect(Response $response, ?string $location = '/', ?string $message = 'Your post was successfully created!'): void
    {
        Application::$app->session->setFlash('success', $message);
        $response->redirect($location);
        exit();
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