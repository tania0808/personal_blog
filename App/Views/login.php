<section class="bg-gray-50">
	<div class="flex flex-col items-center px-6 py-8 mx-auto md:h-screen lg:py-0">
		<div class="w-full mt-10 bg-white rounded-lg shadow sm:max-w-md xl:p-0">
			<div class="p-6 space-y-4 md:space-y-6 sm:p-8">
				<h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
					Sign in to your account
				</h1>
				<form class="space-y-4 md:space-y-6" action="#">
					<div>
						<label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
						<input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="name@company.com" required="">
					</div>
					<div>
						<label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
						<input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
					</div>
					<div class="flex items-center justify-end">
						<a href="#" class="text-sm font-medium text-primary-600 hover:underline">Forgot password?</a>
					</div>
					<button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Sign in</button>
					<p class="text-sm font-light text-gray-500">
						Don’t have an account yet? <a href="/register" class="font-medium text-primary-600 hover:underline">Sign up</a>
					</p>
				</form>
			</div>
		</div>
	</div>
</section>
