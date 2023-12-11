<?php $this->title = 'Home'; ?>

<section id="about" class="w-full flex flex-col md:flex-row mx-auto px-10 md:px-8 py-8">
    <div class="flex flex-col flex-1 gap-10 justify-center px-0 md:px-10 pb-8 md:pb-0">
        <span class="text-neutral-500 text-lg font-semibold">Junior Front-End Developer</span>
        <h1 class="text-header font-black text-5xl">I'm Tania</h1>
        <p class="lg:w-3/4 w-full font-semibold text-justify text-lg">
            I work as a Junior Full Stack Developer at the top-tier company Actual,
        where I am currently pursuing an apprenticeship. Joining Actual has been an exciting opportunity for me
        to enhance my skills and contribute to meaningful projects in the world of web development.</p>
        <div class="flex gap-4 text-3xl text-blue-800 md:w-3/4 w-full justify-around items-center">
            <button class="w-fit text-xl bg-blue-800 hover:bg-blue-900 text-white font-bold
            py-2 px-4 rounded inline-flex items-center">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/>
                </svg>
                <a href="/public/assets/portfolio.pdf" download>CV</a>
            </button>
            <a href="https://github.com/tania0808" target="_blank"
               class="hover:text-blue-900 transition ease-linear hover:scale-125">
                <i class="fab fa-github"></i>
            </a>
            <a href="https://www.linkedin.com/in/tetiana-his/" target="_blank"
               class="hover:text-blue-900 transition ease-linear hover:scale-125">
                <i class="fab fa-linkedin"></i>
            </a>
            <a href="mailto:tania08082000@gmail.com" target="_blank"
               class="hover:text-blue-900 transition ease-linear hover:scale-125">
                <i class="fas fa-envelope"></i>
            </a>
        </div>
    </div>
    <div class="h-[400px] flex-1 flex justify-center align-items-center my-auto md:mt-4">
        <img class="md:w-full max-w-sm  max-w-md h-auto md:mt-4 rounded-lg"
             src="/public/assets/photo.jpg" alt="avatar"/>
    </div>
</section>
