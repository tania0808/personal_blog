<?php use App\Core\Application;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

$this->title = 'Post';
/** @var $post Post */
/** @var $author User */
/** @var $comments Comment[] */
/** @var $comment Comment */
/** @var $commentAuthors User[] */

$currentUser = Application::$app->session->get('user');
?>

<section class="text-gray-700 body-font overflow-hidden bg-white">
    <div class="container px-5 pt-24 pb-6 mx-auto">
        <div class="lg:w-4/5 mx-auto flex flex-wrap">
            <img alt="ecommerce"
                 class="lg:w-1/2 w-full object-cover object-center rounded border border-gray-200"
                 src="<?php echo $post->getImage_name()
                     ? '/public/images/' . $post->getImage_name()
                     : 'https://www.unfe.org/wp-content/uploads/2019/04/SM-placeholder-1024x512.png' ?>">
            <div class="lg:w-1/2 w-full lg:pl-10 mt-6 lg:mt-0">
                <div class="flex justify-between">
                    <h2 class="text-sm title-font text-gray-500 tracking-widest">
                        <?php echo $author->getFullName(); ?>
                    </h2>
                    <!-- Dropdown menu start -->
                    <?php if ($post->getAuthorId() === $currentUser['id']) : ?>
                    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="btn w-10" type="button">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>

                    <div id="dropdown"
                         class="ms-6 z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
                            <li>
                                <a href="/posts/edit/<?php echo $post->getId(); ?>"
                                   class="block px-4 py-2 hover:bg-gray-100">
                                    Edit
                                </a>
                            </li>
                            <li>
                                <a href="/posts/delete/<?php echo $post->getId(); ?>"
                                   class="block text-red-600 px-4 py-2 hover:bg-gray-100">
                                    Delete
                                </a>
                            </li>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <!-- Dropdown menu end -->
                </div>
                <h1 class="text-gray-900 text-3xl title-font font-medium mb-1 pt-6">
                    <?php echo $post->getTitle(); ?>
                </h1>
                <div class="flex mt-2 items-center pb-5 border-b-2 border-gray-200 mb-5"></div>
                <p class="leading-relaxed"><?php echo $post->getDescription(); ?></p>
                <div class="flex mt-2 items-center pb-2 border-b-2 border-gray-200 mb-2"></div>
                <p class="leading-relaxed text-sm text-gray-400">
                    <?php echo date("F jS, Y", strtotime($post->getCreatedAt())); ?>
                </p>
            </div>
        </div>
    </div>
    <div class="container px-5 lg:w-4/5 pt-6 mx-auto">
        <span class="title-font font-medium text-2xl text-gray-700"><?php echo $post->getBody(); ?></span>
    </div>
</section>

<!-- COMMENTS SECTION -->
<section class="container px-5 pt-24 pb-6 mx-auto">
    <div class="lg:w-4/5 mx-auto flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg lg:text-2xl font-bold text-gray-900">Discussion (<?php echo count($comments)?>)</h2>
        </div>
        <form class="mb-6 max-w-3xl" action="" method="post">
            <div class="py-2 px-4 mb-2 bg-white rounded-lg rounded-t-lg border border-gray-200">
                <label for="comment" class="sr-only">Your comment</label>
                <textarea id="comment" rows="6"
                          name="content"
                          class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none"
                          placeholder="Write a comment...">
                    <?php echo isset($comment) ? $comment->getContent() : ''; ?>
                </textarea>
            </div>
            <?php if (isset($errors['content'])) : ?>
                <p class="mt-2 text-sm text-red-600">
                    <?php foreach ($errors['content'] as $error) : ?>
                        <span class="font-medium"><?php echo $error; ?></span><br>
                    <?php endforeach; ?>
                </p>
            <?php endif; ?>
            <button type="submit"
                    class="mt-2 inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white
                           bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 hover:bg-blue-800">
                Post comment
            </button>
        </form>
        <?php foreach ($comments as $comment) : ?>
            <article class="p-6 text-base bg-white rounded-lg">

                <footer class="flex justify-between items-center mb-2">
                    <div class="flex items-center">
                        <p class="inline-flex items-center mr-3 text-sm text-gray-900 font-semibold"><img
                                    class="mr-2 w-6 h-6 rounded-full"
                                    src="https://static.thenounproject.com/png/354384-200.png"
                                    alt="Michael Gough">
                            <?php echo $commentAuthors[$comment->getAuthorId()]->getFullName() ?>
                        </p>
                        <p class="text-sm text-gray-600">
                            <?php echo date("F jS, Y", strtotime($comment->getCreatedAt())); ?>
                        </p>
                    </div>
                    <button id="dropdownComment1Button" data-dropdown-toggle="dropdownComment1"
                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white
                                   rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50"
                            type="button">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                        <span class="sr-only">Comment settings</span>
                    </button>
                    <?php if ($comment->getAuthorId() === $currentUser['id']) : ?>
                        <!-- Dropdown menu -->
                        <div id="dropdownComment1"
                             class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow">
                            <ul class="py-1 text-sm text-gray-700"
                                aria-labelledby="dropdownMenuIconHorizontalButton">
                                <li>
                                    <a
                                       href="/posts/<?= $post->getId(); ?>/comments/delete/<?= $comment->getId(); ?>"
                                       class="block text-red-600 px-4 py-2 hover:bg-gray-100">
                                        Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </footer>
                <p class="text-gray-500"><?php echo $comment->getContent() ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>