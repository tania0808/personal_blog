<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Comment;
use App\Models\Post;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;

class AdminController extends Controller
{
    private UserRepository $userRepository;
    private PostRepository $postRepository;
    private CommentRepository $commentRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
        $this->userRepository = new UserRepository();
        $this->commentRepository = new CommentRepository();
    }

    public function index(Request $request, Response $response)
    {
        $this->guardAgainstNotAdminUser($response);
        $this->setLayout("admin");

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

        return $this->render('admin/posts', [
            'posts' => $posts,
            'authors' => $authors
        ]);
    }

    public function deletePost(Request $request, Response $response)
    {
        $this->guardAgainstNotAdminUser($response);
        $success = $this->postRepository->delete('posts', $request->routeParams['id']);

        $this->redirect(
            $response,
            $success,
            '/admin/posts',
            'The post was successfully deleted!',
            '/admin/posts'
        );
    }

    public function approvePost(Request $request, Response $response)
    {
        $this->guardAgainstNotAdminUser($response);
        $success = $this->postRepository->updateApprovalStatus(
            'posts',
            $request->routeParams['id'],
            Application::$app->user->getId(),
            true
        );

        $this->redirect(
            $response,
            $success,
            '/admin/posts',
            'The post was approved!',
            '/admin/posts'
        );
    }

    public function disapprovePost(Request $request, Response $response)
    {
        $this->guardAgainstNotAdminUser($response);
        $success = $this->postRepository->updateApprovalStatus(
            'posts',
            $request->routeParams['id'],
            Application::$app->user->getId(),
            false
        );

        $this->redirect(
            $response,
            $success,
            '/admin/posts',
            'The post was disapproved!',
            '/admin/posts'
        );
    }
    public function approveComment(Request $request, Response $response)
    {
        $this->guardAgainstNotAdminUser($response);
        $success = $this->postRepository->updateApprovalStatus(
            'comments',
            $request->routeParams['id'],
            Application::$app->user->getId(),
            true
        );

        $this->redirect(
            $response,
            $success,
            '/admin/comments',
            'The comment was approved!',
            '/admin/comments'
        );
    }

    public function disapproveComment(Request $request, Response $response)
    {
        $this->guardAgainstNotAdminUser($response);
        $success = $this->postRepository->updateApprovalStatus(
            'comments',
            $request->routeParams['id'],
            Application::$app->user->getId(),
            false
        );

        $this->redirect(
            $response,
            $success,
            '/admin/comments',
            'The comment was disapproved!',
            '/admin/comments'
        );
    }

    public function showComments(Request $request, Response $response)
    {
        $this->guardAgainstNotAdminUser($response);
        $this->setLayout('admin');
        $comments = $this->commentRepository->getAll();
        $authorIds = array_values(
            array_unique(
                array_map(
                    fn (Comment $comment) => $comment->getAuthorId(),
                    $comments
                )
            )
        );
        $authors = $this->userRepository->getByIds($authorIds);

        return $this->render('admin/comments', [
            'comments' => $comments,
            'authors' => $authors
        ]);
    }

    public function deleteComment(Request $request, Response $response)
    {
        $this->guardAgainstNotAdminUser($response);
        $success = $this->commentRepository->delete('comments', $request->routeParams['id']);

        $this->redirect(
            $response,
            $success,
            '/admin/comments',
            'The comment was deleted!',
            '/admin/comments'
        );
    }
}
