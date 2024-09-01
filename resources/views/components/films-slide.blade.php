<div class="px-4 w-5/6">
    <div class="grid p-0 m-0 mt-5 w-full md:grid-cols-4 gap-7 xl:grid-cols-6 grid-cols-2 justify-items-center">
        @foreach ($films as $film)
            <a href="/films/{{ $film->slug }}"
                class="transition-transform duration-300 ease-in-out transform hover:scale-90 p-3 box-bordertext-white 
                flex flex-col justify-start items-center bg-blue-950 rounded-xl hover:bg-midBlue md:w-auto w-36 xl:w-52 xl:h-[380px] shadow-blue-900 shadow-md">
                <div class="w-full h-3/4 aspect-[4/6] overflow-hidden">
                    <img class="w-full h-full object-cover"
                        src={{ $film->cover_image_url ?? asset('gudangfilm-logo.png') }} alt={{ $film->title }}>
                </div>
                <div class="flex flex-col items-center max-h-16">
                    <h1 class="w-full text-center mt-3 md:text-base text-sm" title="{{ $film->title }}">
                        <span class="block lg:hidden">{{ Str::limit($film->title, 20) }}</span>
                        <span class="hidden lg:block">{{ Str::limit($film->title, 35) }}</span>
                    </h1>
                    <h4 class="text-xs text-gray-400">{{ $film->release_year }}</h4>
                </div>

            </a>
        @endforeach
    </div>
</div>
