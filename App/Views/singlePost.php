<?php $this->title = 'Post';
/** @var $post \App\Models\Post */
?>

<section class="text-gray-700 body-font overflow-hidden bg-white">
	<div class="container px-5 pt-24 pb-6 mx-auto">
		<div class="lg:w-4/5 mx-auto flex flex-wrap">
			<img alt="ecommerce" class="lg:w-1/2 w-full object-cover object-center rounded border border-gray-200" src="<?php echo $post->image_name ? '/public/images/' . $post->image_name : 'https://www.unfe.org/wp-content/uploads/2019/04/SM-placeholder-1024x512.png' ?>">
			<div class="lg:w-1/2 w-full lg:pl-10 mt-6 lg:mt-0">
				<div class="flex justify-between">
					<h2 class="text-sm title-font text-gray-500 tracking-widest"><?php echo $post->first_name . ' ' . $post->last_name ; ?></h2>
					<!-- Dropdown menu start -->
					<button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="btn" type="button">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
							<path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
						</svg>
					</button>

					<div id="dropdown" class="ms-6 z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
						<ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
							<li>
								<a href="/posts/edit/<?php echo $post->id; ?>" class="block px-4 py-2 hover:bg-gray-100">Edit</a>
							</li>
							<li>
								<a href="#" class="block text-red-600 px-4 py-2 hover:bg-gray-100">Delete</a>
							</li>
						</ul>
					</div>
					<!-- Dropdown menu end -->
				</div>
				<h1 class="text-gray-900 text-3xl title-font font-medium mb-1 pt-6"><?php echo $post->title; ?></h1>
				<div class="flex mt-2 items-center pb-5 border-b-2 border-gray-200 mb-5"></div>
				<p class="leading-relaxed"><?php echo $post->description; ?></p>
				<div class="flex mt-2 items-center pb-2 border-b-2 border-gray-200 mb-2"></div>
				<p class="leading-relaxed text-sm text-gray-400"><?php echo date("F jS, Y", strtotime($post->created_at)); ?></p>
				<span class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
              </span>
			</div>
		</div>
	</div>
	<div class="container lg:w-4/5 pt-24 mx-auto">
		<span class="title-font font-medium text-2xl text-gray-700"><?php echo $post->body; ?></span>
		<button class="flex ml-auto text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded">Button</button>
	</div>
</section>