<?php use App\Core\ContactForm;

$this->title = 'Contact';

/** @var $model ContactForm */
?>
<section class="bg-gray-50">
	<div class="flex flex-col items-center px-6 py-8 mx-auto md:h-screen lg:py-0">
		<div class="w-full mt-10 bg-white rounded-lg shadow sm:max-w-md xl:p-0">
			<div class="p-6 space-y-4 md:space-y-6 sm:p-8">
				<h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900">Contact Me</h2>
				<form class="space-y-4 md:space-y-6" action="" method="post">
					<div>
						<label class="block mb-2 text-sm font-medium text-gray-900" for="subject">Subject</label>
						<input type="text" name="subject" value="<?php echo $model->getSubject() ?>" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:border-blue-500 focus:outline-none focus:ring block w-full p-2.5">
                        <?php if(isset($errors['subject'])) : ?>
							<p class="mt-2 text-sm text-red-600">
                                <?php foreach ($errors['subject'] as $error) : ?>
									<span class="font-medium"><?php echo $error; ?></span><br>
                                <?php endforeach; ?>
							</p>
                        <?php endif; ?>
					</div>
					<div>
						<label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
						<input type="text" name="name" value="<?php echo $model->getName() ?>" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:border-blue-500 focus:outline-none focus:ring block w-full p-2.5">
                        <?php if(isset($errors['name'])) : ?>
							<p class="mt-2 text-sm text-red-600">
                                <?php foreach ($errors['name'] as $error) : ?>
									<span class="font-medium"><?php echo $error; ?></span><br>
                                <?php endforeach; ?>
							</p>
                        <?php endif; ?>
					</div>
					<div>
						<label class="block mb-2 text-sm font-medium text-gray-900" for="email">Email</label>
						<input type="text" name="email" value="<?php echo $model->getEmail() ?>" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:border-blue-500 focus:outline-none focus:ring block w-full p-2.5">
                        <?php if(isset($errors['email'])) : ?>
							<p class="mt-2 text-sm text-red-600">
                                <?php foreach ($errors['email'] as $error) : ?>
									<span class="font-medium"><?php echo $error; ?></span><br>
                                <?php endforeach; ?>
							</p>
                        <?php endif; ?>
					</div>
					<div>
						<label class="block mb-2 text-sm font-medium text-gray-900">Body</label>
						<input type="text" name="body" value="<?php echo $model->getBody() ?>" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:border-blue-500 focus:outline-none focus:ring block w-full p-2.5">
                        <?php if(isset($errors['body'])) : ?>
							<p class="mt-2 text-sm text-red-600">
                                <?php foreach ($errors['body'] as $error) : ?>
									<span class="font-medium"><?php echo $error; ?></span><br>
                                <?php endforeach; ?>
							</p>
                        <?php endif; ?>
					</div>
					<button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Send</button>
				</form>
			</div>
		</div>
	</div>
</section>
