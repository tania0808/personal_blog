<?php use App\Core\Form\Form;
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
    <?php echo $form->field($model, 'body', 'Body', 'Body') ?>

	<button type="submit" class="w-fit text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Add the post</button>

    <?php echo Form::end(); ?>
</div>