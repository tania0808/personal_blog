<?php

use App\Models\User;

$this->title = 'Register';

/** @var $user User */
/** @var $errors */

ob_start();
?>

<section class="bg-gray-50">
    <div class="flex flex-col items-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div class="w-full mt-10 bg-white rounded-lg shadow sm:max-w-md xl:p-0">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                    Create an account
                </h1>
                <form class="space-y-4 md:space-y-6" action="" method="post">
                    <div>
                        <label for="firstName" class="block mb-2 text-sm font-medium text-gray-900">First Name
                            <input type="text" name="firstName" value="<?php echo $user->getFirstName() ?>"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                                          focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                        </label>
                        <?php if (isset($errors['first_name'])) : ?>
                            <p class="mt-2 text-sm text-red-600">
                                <?php foreach ($errors['first_name'] as $error) : ?>
                                    <span class="font-medium"><?php echo $error; ?></span><br>
                                <?php endforeach; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="lastName" class="block mb-2 text-sm font-medium text-gray-900">Last Name
                            <input type="text" name="lastName" value="<?php echo $user->getLastName() ?>"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                                          focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                        </label>
                        <?php if (isset($errors['last_name'])) : ?>
                            <p class="mt-2 text-sm text-red-600">
                                <?php foreach ($errors['last_name'] as $error) : ?>
                                    <span class="font-medium"><?php echo $error; ?></span><br>
                                <?php endforeach; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email
                            <input type="text" name="email" value="<?php echo $user->getEmail() ?>"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                                          focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                        </label>
                        <?php if (isset($errors['email'])) : ?>
                            <p class="mt-2 text-sm text-red-600">
                                <?php foreach ($errors['email'] as $error) : ?>
                                    <span class="font-medium"><?php echo $error; ?></span><br>
                                <?php endforeach; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password
                            <input type="password" name="password" value="<?php echo $user->getPassword() ?>"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                                          focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                        </label>
                        <?php if (isset($errors['password'])) : ?>
                            <p class="mt-2 text-sm text-red-600">
                                <?php foreach ($errors['password'] as $error) : ?>
                                    <span class="font-medium"><?php echo $error; ?></span><br>
                                <?php endforeach; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700
                                          focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium
                                          rounded-lg text-sm px-5 py-2.5 text-center">
                        Create an account
                    </button>
                </form>
                <p class="text-sm font-light text-gray-500">
                    Already have an account?
                    <a href="/login" class="font-medium text-primary-600 hover:underline">
                        Login here
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>
