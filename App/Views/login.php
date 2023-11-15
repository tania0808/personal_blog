<?php
$this->title = 'Login';

ob_start();
use App\Core\Form\Form;
use App\Models\User;

/** @var $model User */
?>
<section class="bg-gray-50">
	<div class="flex flex-col items-center px-6 py-8 mx-auto md:h-screen lg:py-0">
		<div class="w-full mt-10 bg-white rounded-lg shadow sm:max-w-md xl:p-0">
			<div class="p-6 space-y-4 md:space-y-6 sm:p-8">
				<h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
					Sign in to your account
				</h1>
                <?php $form = Form::begin('', 'post'); ?>
                <?php echo $form->field($model, 'email', 'Email', 'email') ?>
                <?php echo $form->field($model, 'password', 'Password', 'password') ?>
				<div class="flex items-center justify-end">
					<a href="#" class="text-sm font-medium text-primary-600 hover:underline">Forgot password?</a>
				</div>
				<button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Sign in</button>
				<p class="text-sm font-light text-gray-500">
					Don’t have an account yet? <a href="/register" class="font-medium text-primary-600 hover:underline">Sign up</a>
				</p>
				<?php echo Form::end(); ?>
			</div>
		</div>
	</div>
</section>
