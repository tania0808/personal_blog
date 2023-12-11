<?php
$this->title = 'Login';

ob_start();
use App\Models\User;

/** @var $user User */
?>
<section class="bg-gray-50">
    <div class="flex flex-col items-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div class="w-full mt-10 bg-white rounded-lg shadow sm:max-w-md xl:p-0">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                    Log in to your account
                </h1>
                <form class="space-y-4 md:space-y-6" action="" method="post">
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
                    <?php if (!empty($authError)) : ?>
                        <p class="mt-2 text-sm text-red-600">
                            <span class="font-medium"><?php echo $authError; ?></span><br>
                        </p>
                    <?php endif; ?>
                    <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700
                                                 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium
                                                 rounded-lg text-sm px-5 py-2.5 text-center">Login</button>
                </form>
                <p class="text-sm font-light text-gray-500">
                    Don’t have an account yet?
                    <a href="/register" class="font-medium text-primary-600 hover:underline">
                        Sign up
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>
