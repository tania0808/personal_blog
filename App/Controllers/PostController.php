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
use App\Repositories\UserRepository;

class PostController extends Controller {
    private readonly PostRepository $postRepository;
    private readonly UserRepository $userRepository;

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['edit']));
        $this->postRepository = new PostRepository();
        $this->userRepository = new UserRepository();
    }


    public function index()
    {
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

        return $this->render('post/posts', [
            'posts' => $posts,
            'authors' => $authors,
        ]);
    }

    public function show(Request $request, Response $response) {
        $post = $this->postRepository->getById($request->routeParams['id']);
        $author = $this->userRepository->getById($post->getAuthorId());

        return $this->render('post/singlePost', [
            'post' => $post,
            'author' => $author
        ]);
    }

    public function store(Request $request, Response $response)
    {
        $post = $this->loadPostDataFromRequest($request);
        $postFormValidator = new PostFormValidator();
        $errors = [];

        if ($request->isPost()) {
            $imageUpload = $this->handleImageUpload($post, $errors);
            $isValidForm = $postFormValidator->validate($request);
            $errors = $postFormValidator->getErrors();

            if ($isValidForm && empty($errors['image_name']) && $this->postRepository->create($post)) {
                $this->handleImageMove($post, $imageUpload);
                $this->handleSuccessRedirect($response, "/posts");
            }
        }

        return $this->render('post/newPost', ['post' => $post, 'errors' => $errors]);
    }

    public function edit(Request $request, Response $response) {
        $existingPost = $this->postRepository->getById($request->routeParams['id']);
        $this->guardAgainstNotAuthorizedUser($existingPost);

        if ($request->isPost()) {
            $postFormValidator = new PostFormValidator();
            $newPost = $this->loadPostDataFromRequest($request);
            $isValidForm = $postFormValidator->validate($request);
            $errors = $postFormValidator->getErrors();
            $imageUpload = $this->handleImageUpload($newPost, $errors, $existingPost);

            if ($isValidForm && empty($errors['image_name']) && $this->postRepository->update($existingPost->getId(), $newPost)) {
                $this->handleImageMove($newPost, $imageUpload);
                $this->handleImageDelete($existingPost);
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

    public function handleImageUpload(Post $post, array &$errors, ?Post $existingPost = null): ?ImageUpload
    {
        if(!empty($post->getImageName())) {
            $imageUpload = new ImageUpload($_FILES['imageName']);
            $errors['image_name'] = $imageUpload->getErrors();
            !empty($_FILES['imageName']['name']) ? $post->setImageName($imageUpload->image_name) : $post->setImageName($existingPost->getImageName());

            return $imageUpload;
        }
        return null;
    }

    public function handleImageDelete(Post $existingPost): void
    {
        $uploads_folder = __DIR__.'/../../public/images/';

        if (!empty($existingPost->getImageName()) && !empty($_FILES['imageName']['name'])) {
            unlink($uploads_folder . $existingPost->getImageName());
        }
    }

    private function handleImageMove(Post $post, ?ImageUpload $imageUpload = null): void
    {
        if($post->getImageName() !== null && $imageUpload !== null) {
            $imageUpload->moveFile();
        }
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