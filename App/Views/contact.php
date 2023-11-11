<?php $this->title = 'Contact';

use App\Core\Form\Form;
use App\Models\User;

/** @var $model User */
?>
<section class="bg-gray-50">
	<div class="flex flex-col items-center px-6 py-8 mx-auto md:h-screen lg:py-0">
		<div class="w-full mt-10 bg-white rounded-lg shadow sm:max-w-md xl:p-0">
			<div class="p-6 space-y-4 md:space-y-6 sm:p-8">
				<h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">Contact Me</h2>
                <?php $form = Form::begin('', 'post'); ?>
                <?php echo $form->field($model, 'subject', 'Object', 'text' ) ?>
                <?php echo $form->field($model, 'name', 'Name', 'text') ?>
                <?php echo $form->field($model, 'email', 'Email', 'email') ?>
                <?php echo $form->field($model, 'body', 'Message', 'text') ?>

				<button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Send</button>
                <?php echo Form::end(); ?>
			</div>
		</div>
	</div>
</section>
