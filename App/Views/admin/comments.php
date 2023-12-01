<?php use App\Models\Comment;
use App\Models\User;

$this->title = 'Admin';
/** @var $comments Comment[] */
/** @var $authors User[] */

?>
<!-- component -->
<div class="flex flex-wrap -mx-3 mb-5">
    <div class="w-full max-w-full px-3 mb-6  mx-auto">
        <div class="relative flex-[1_auto] flex flex-col break-words
                    min-w-0 bg-clip-border rounded-[.95rem] bg-white m-5">
            <div class="relative flex flex-col min-w-0 break-words border
                        border-dashed bg-clip-border rounded-2xl border-stone-200 bg-light/30">
                <!-- card header -->
                <div class="px-9 pt-2 flex justify-between items-stretch flex-wrap min-h-[70px] pb-0 bg-transparent">
                    <h3 class="flex flex-col items-start justify-center m-2 ml-0 font-medium text-xl/tight text-dark">
                        <span class="mr-3 font-semibold text-dark">Comments</span>
                    </h3>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Comment
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Author
                            </th>
                            <th scope="col" class="px-6 py-3 pl-12">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 pl-12">
                                Created
                            </th>
                            <th scope="col" class="px-12 py-3 pl-16">
                                Action
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Details
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($comments as $comment) : ?>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?php echo $comment->getContent(); ?>
                                    </th>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?php echo $authors[$comment->getAuthorId()]->getFullName() ?>
                                    </th>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?php if ($comment->getApprovedAt() !== null) : ?>
                                        <span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                            <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                            Approved
                                        </span>
                                        <?php else : ?>
                                        <span class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                            <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                            Not Approved
                                        </span>
                                        <?php endif ?>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?php echo date("F jS, Y", strtotime($comment->getCreatedAt())); ?>
                                    </td>
                                    <td class="flex items-center px-6 py-4 gap-4">
                                        <?php if ($comment->getApprovedAt() !== null) : ?>
                                        <a href="/admin/comments/disapprove/<?php echo $comment->getId(); ?>"
                                           class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            Disapprove
                                        </a>
                                        <?php else : ?>
                                        <a href="/admin/comments/approve/<?php echo $comment->getId(); ?>"
                                           class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            Approve
                                        </a>
                                        <?php endif; ?>
                                        <a href="/admin/comments/delete/<?php echo $comment->getId(); ?>"
                                           class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">
                                            Remove
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="/posts/<?php echo $comment->getPostId(); ?>">
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
