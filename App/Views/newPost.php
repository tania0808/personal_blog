<?php use App\Core\Form\Form;
use App\Core\Form\TextareaField;
use App\Models\User;

$this->title = 'New post';
/** @var $model \App\Models\Post */
?>

<div class="heading text-center font-bold text-2xl m-5 text-gray-800">New Post</div>
<style>
    body {background:white !important;}
</style>
<div class="editor mx-auto w-10/12 flex flex-col text-gray-800 border border-gray-300 p-4 shadow-lg max-w-2xl">
    <?php $form = Form::begin('', 'post'); ?>
    <?php echo $form->field($model, 'title', 'Title', 'Title') ?>
    <?php echo $form->field($model, 'description', 'Description', 'Description' ) ?>
    <?php echo new TextareaField($model, 'body', 'Body') ?>

	<div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
		<div class="space-y-1 text-center text-indigo-600">
			<svg class="mx-auto h-12 w-12 text-indigo-600" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
				<path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
			</svg>
			<div class="flex text-sm text-gray-600 justify-center">
				<label for="file-upload" class="text-center relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
					<span class="flex">Upload a file</span>
                    <?php echo $form->field($model, 'image_name', 'Image', 'file' ) ?>
				</label>
			</div>
			<p class="text-xs">
				PNG, JPG, GIF up to 10MB
			</p>
		</div>
	</div>
	<button type="submit" class="w-fit text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Add the post</button>

    <?php echo Form::end(); ?>
</div>