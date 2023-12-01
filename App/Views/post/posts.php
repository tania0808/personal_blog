<?php use App\Models\Post;
use App\Models\User;

$this->title = 'All posts';

/** @var $posts Post[] */
/** @var $authors User[] */
?>

<div class="heading text-center font-bold text-2xl m-5 text-gray-800">All posts</div>
<a href="/post/create"
   class="text-white ml-4 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium
          rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none ">
    Add new
</a>

<section class="flex flex-row flex-wrap mx-auto">
    <!-- Card Component -->
<?php foreach ($posts as $post) : ?>
    <div class="transition-all duration-150 flex w-full px-4 py-6 md:w-1/2 lg:w-1/3">
        <div class="flex flex-col w-full items-stretch min-h-full pb-4 mb-6 transition-all duration-150
                    bg-white rounded-lg shadow-lg hover:shadow-2xl">
            <div class="md:flex-shrink-0">
                <img src="<?php echo $post->getImage_name()
                    ? '/public/images/' . $post->getImage_name()
                    : 'https://www.unfe.org/wp-content/uploads/2019/04/SM-placeholder-1024x512.png' ?>"
                     alt="Blog Cover" class="object-cover w-full rounded-lg rounded-b-none md:h-56"/>
            </div>
            <div class="flex flex-wrap items-center flex-1 px-4 py-1 text-center mx-auto">
                <a href="/posts/<?php echo $post->getId(); ?>" class="hover:underline">
                    <h2 class="text-2xl font-bold tracking-normal text-gray-800">
                        <?php echo $post->getTitle(); ?>
                    </h2>
                </a>
            </div>
            <hr class="border-gray-300" />
            <p
                    class="flex flex-row flex-wrap w-full px-4 py-2 overflow-hidden text-sm text-justify text-gray-700"
            >
                <?php echo $post->getDescription(); ?>
            </p>
            <hr class="border-gray-300" />
            <section class="px-4 py-2 mt-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center flex-1">
                        <img
                                class="object-cover h-10 rounded-full"
                                src="https://thumbs.dreamstime.com/b/default-avatar-photo-placeholder-profile-icon-eps-file-easy-to-edit-default-avatar-photo-placeholder-profile-icon-124557887.jpg"
                                alt="Avatar"
                        />
                        <div class="flex flex-col mx-2">
                            <a href="" class="font-semibold text-gray-700 hover:underline">
                                <?php echo $authors[$post->getAuthorId()]->getFullName() ?>
                            </a>
                            <span class="text-xs text-gray-600">
                                <?php echo date("F jS, Y", strtotime($post->getCreatedAt())); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
<?php endforeach; ?>

</section>
