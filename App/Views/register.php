<?php
/** @var $model \App\Models\User */

ob_start();
use App\Core\Form\Form;
?>

<section class="bg-gray-50">
	<div class="flex flex-col items-center px-6 py-8 mx-auto md:h-screen lg:py-0">
		<div class="w-full mt-10 bg-white rounded-lg shadow sm:max-w-md xl:p-0">
			<div class="p-6 space-y-4 md:space-y-6 sm:p-8">
				<h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
					Create an account
				</h1>
                <?php $form = Form::begin('', 'post'); ?>
				<?php echo $form->field($model, 'first_name', 'text', 'First Name') ?>
				<?php echo $form->field($model, 'last_name', 'text', 'Last Name' ) ?>
				<?php echo $form->field($model, 'email', 'email', 'Email') ?>
				<?php echo $form->field($model, 'password', 'password', 'Password') ?>
				<?php echo $form->field($model, 'confirmPassword', 'password', 'Password confirm') ?>

				<button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Create an account</button>
				<p class="text-sm font-light text-gray-500">
					Already have an account? <a href="/login" class="font-medium text-primary-600 hover:underline">Login here</a>
				</p>
                <?php echo Form::end(); ?>
			</div>
		</div>
	</div>
</section>
