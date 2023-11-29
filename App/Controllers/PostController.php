<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\FormValidator\CommentFormValidator;
use App\Core\FormValidator\PostFormValidator;
use App\Core\ImageUpload;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\Comment;
use App\Models\Post;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;

class PostController extends Controller
{
    private readonly PostRepository $postRepository;
    private readonly UserRepository $userRepository;
    private readonly CommentRepository $commentRepository;

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['edit']));
        $this->postRepository = new PostRepository();
        $this->userRepository = new UserRepository();
        $this->commentRepository = new CommentRepository();
    }

    public function addComment(Request $request, Response $response)
    {
        $postData = $this->getPostData($request);
        $comment = new Comment();
        $commentFormValidator = new CommentFormValidator();

        $comment->loadData($request->getBody());
        $comment->setPostId($request->routeParams['id']);
        $comment->setAuthorId(Application::$app->user->getId());

        $isValidForm = $commentFormValidator->validate($request);
        $errors = $commentFormValidator->getErrors();

        if ($isValidForm && $this->commentRepository->create($comment)) {
            $this->handleSuccessRedirect($response, "/posts/{$request->routeParams['id']}", 'Your comment has been successfully submitted for validation');
        }
        return $this->render("post/singlePost", [
            'errors' => $errors,
            'comment' => $comment,
            'post' => $postData['post'],
            'author' => $postData['author'],
            'comments' => $postData['comments'],
            'commentAuthors' => $postData['commentAuthors'],
        ]);
    }

    public function deleteComment(Request $request, Response $response): void
    {
        $success = $this->commentRepository->delete('comments', $request->routeParams['id']);
        $this->redirect($response, $success, "/posts/{$request->routeParams['postId']}", 'Your comment was successfully deleted!', '/posts');
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

    public function show(Request $request, Response $response)
    {
        $postData = $this->getPostData($request);

        return $this->render('post/singlePost', [
            'post' => $postData['post'],
            'author' => $postData['author'],
            'comments' => $postData['comments'],
            'commentAuthors' => $postData['commentAuthors'],
        ]);
    }

    public function getPostData(Request $request)
    {
        $post = $this->postRepository->getById($request->routeParams['id']);
        $author = $this->userRepository->getById($post->getAuthorId());
        $comments = $this->commentRepository->getAllByPostId($post->getId());

        $authorIds = array_values(
            array_unique(
                array_map(
                    fn (Comment $comment) => $comment->getAuthorId(),
                    $comments
                )
            )
        );

        $commentAuthors = $this->userRepository->getByIds($authorIds);

        return [
            'post' => $post,
            'author' => $author,
            'comments' => $comments,
            'commentAuthors' => $commentAuthors,
        ];
    }

    public function store(Request $request, Response $response)
    {
        $post = $this->loadPostDataFromRequest($request);
        $postFormValidator = new PostFormValidator();
        $errors = [];

        if ($request->isPost()) {
            $isValidForm = $postFormValidator->validate($request);
            $errors = $postFormValidator->getErrors();
            $imageUpload = $this->handleImageUpload($post, $errors);

            if ($isValidForm && empty($errors['image_name']) && $this->postRepository->create($post)) {
                $this->handleImageMove($post, $imageUpload);
                $this->handleSuccessRedirect($response, "/posts");
            }
            return $this->render('post/newPost', ['post' => $post, 'errors' => $errors]);
        }
        return $this->render('post/newPost', ['post' => $post, 'errors' => []]);
    }

    public function edit(Request $request, Response $response)
    {
        $existingPost = $this->postRepository->getById($request->routeParams['id']);
        $this->guardAgainstNotAuthorizedUser($response, $existingPost);

        if ($request->isPost()) {
            $postFormValidator = new PostFormValidator();
            $newPost = $this->loadPostDataFromRequest($request);

            $isValidForm = $postFormValidator->validate($request);
            $errors = $postFormValidator->getErrors();
            $imageUpload = $this->handleImageUpload($newPost, $errors, $existingPost);

            if ($isValidForm && empty($errors['image_name']) && $this->postRepository->update($existingPost->getId(), $newPost)) {
                if(!empty($_FILES['imageName']['name'])) {
                    $this->handleImageMove($newPost, $imageUpload);
                    $this->handleImageDelete($existingPost);
                }
                $this->handleSuccessRedirect($response, "/posts/{$existingPost->getId()}", 'Your post was successfully edited!');
            }

            return $this->render("post/editPost", ['post' => $newPost, 'errors' => $errors]);

        }

        return $this->render('post/editPost', ['post' => $existingPost, 'errors' => []]);
    }

    public function delete(Request $request, Response $response)
    {
        $existingPost = $this->postRepository->getById($request->routeParams['id']);
        $this->guardAgainstNotAuthorizedUser($response, $existingPost);

        if($this->postRepository->delete('posts', $request->routeParams['id'])) {
            $this->handleImageDelete($existingPost);
            $this->handleSuccessRedirect($response, '/posts', 'Your post was successfully deleted!');
        }

        $this->handleErrorRedirect($response, "/posts");
    }

    public function loadPostDataFromRequest(Request $request): Post
    {
        $post = new Post();
        $post->loadData($request->getBody());
        $post->setAuthorId(Application::$app->user->getId());

        return $post;
    }

    public function handleImageUpload(Post $post, array &$errors, ?Post $existingPost = null)
    {
        if(!empty($_FILES['imageName']['name'])) {
            $imageUpload = new ImageUpload($_FILES['imageName']);
            $errors['image_name'] = $imageUpload->getErrors();
            $post->setImageName($imageUpload->image_name);
            return $imageUpload;
        }
        if($existingPost !== null) {
            $post->setImageName($existingPost->getImage_name());
        }
        return null;
    }

    public function handleImageDelete(Post $existingPost): void
    {
        $uploads_folder = __DIR__.'/../../public/images/';

        if (!empty($existingPost->getImage_name())) {
            unlink($uploads_folder . $existingPost->getImage_name());
        }
    }

    private function handleImageMove(Post $post, ?ImageUpload $imageUpload = null): void
    {
        if($post->getImage_name() !== null && $imageUpload !== null) {
            $imageUpload->moveFile();
        }
    }

    private function guardAgainstNotAuthorizedUser(Response $response, Post $post): void
    {
        if(Application::$app->session->get('user')['id'] === $post->getAuthorId() || Application::$app->session->get('user')['is_admin']) {
            return;
        }

        $this->handleErrorRedirect($response, "/posts/{$post->getId()}", "You don't have the access to this page !");
    }


}
