<?php
/** @var $exception Exception */
?>
<div class="mx-auto h-[80vh] pt-5 flex justify-center items-center">
    <div class="flex flex-col items-center">
        <div class="text-indigo-500 font-bold text-7xl">
            <?php echo $exception->getCode() ?>
        </div>

        <div class="text-gray-400 font-medium text-sm md:text-xl lg:text-2xl mt-8">
            The page you are looking for could not be found.
        </div>

        <a href="/posts"
           class="text-white ml-4 mt-6 bg-indigo-500 hover:bg-indigo-500 focus:ring-4 focus:ring-blue-300 font-medium
          rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none ">
            View all posts
        </a>
    </div>
</div>