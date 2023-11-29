<?php

use App\Models\Post;

$this->title = 'Edit a post';
/** @var $post Post */
/** @var $errors */
?>

<div class="heading text-center font-bold text-2xl m-5 text-gray-800">New Post</div>
<style>
    body {background:white !important;}
</style>
<div class="editor mx-auto w-10/12 flex flex-col text-gray-800 border border-gray-300 p-4 shadow-lg max-w-2xl">
	<form class="space-y-4 md:space-y-6" method="post" enctype="multipart/form-data">
		<div>
			<label class="block mb-2 text-sm font-medium text-gray-900">Title</label>
			<input type="text" name="title" value="<?php echo $post->getTitle() ?>" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:border-blue-500 focus:outline-none focus:ring block w-full p-2.5">
            <?php if(isset($errors['title'])) : ?>
	            <p class="mt-2 text-sm text-red-600">
                    <?php foreach ($errors['title'] as $error) : ?>
		                <span class="font-medium"><?php echo $error; ?></span><br>
		            <?php endforeach; ?>
	            </p>
            <?php endif; ?>
		</div>
		<div>
			<label class="block mb-2 text-sm font-medium text-gray-900">Description</label>
			<input type="text" name="description" value="<?php echo $post->getDescription() ?>" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:border-blue-500 focus:outline-none focus:ring block w-full p-2.5">
            <?php if(isset($errors['description'])) : ?>
				<p class="mt-2 text-sm text-red-600">
                    <?php foreach ($errors['description'] as $error) : ?>
						<span class="font-medium"><?php echo $error; ?></span><br>
                    <?php endforeach; ?>
				</p>
            <?php endif; ?>
		</div>

		<div>
			<label class="block mb-2 text-sm font-medium text-gray-900">Body</label>
			<textarea name="body" rows="10" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:outline-none focus:ring"><?php echo $post->getBody() ?></textarea>
            <?php if(isset($errors['body'])) : ?>
				<p class="mt-2 text-sm text-red-600">
                    <?php foreach ($errors['body'] as $error) : ?>
						<span class="font-medium"><?php echo $error; ?></span><br>
                    <?php endforeach; ?>
				</p>
            <?php endif; ?>
		</div>

		<div class="mt-6 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
			<div class="space-y-1 text-center text-blue-700">
				<svg class="mx-auto h-12 w-12 text-blue-700" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
					<path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
				<p class="text-xs">
					PNG, JPG, GIF up to 2MB
				</p>
				<div class="flex pt-4 text-sm text-gray-600 justify-center">
					<label for="file-upload" class="text-center relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
						<input type="file" name="imageName" value="<?php echo $post->getImage_name() ?>" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <?php if(isset($errors['image_name'])) : ?>
							<p class="mt-2 text-sm text-red-600">
                                <?php foreach ($errors['image_name'] as $error) : ?>
									<span class="font-medium"><?php echo $error; ?></span><br>
                                <?php endforeach; ?>
							</p>
                        <?php endif; ?>
					</label>
				</div>
			</div>
		</div>
		<button type="submit" class="w-fit mt-8 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Edit</button>
	</form>
</div>