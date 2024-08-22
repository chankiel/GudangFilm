<div class="lg:px-40 md:px-24 mx-auto px-4">
    <div class="flex flex-wrap justify-center gap-5 p-0 m-0 mt-4 w-full">
        @foreach ($films as $film)
            <a href="/films/{{ $film->slug }}" class="transition-transform duration-300 ease-in-out transform hover:scale-90 min-w-24 p-3 box-bordertext-white 
                film flex flex-col justify-start items-center lg:max-w-48 max-w-24 md:max-w-32 bg-blue-950 rounded-xl hover:bg-midBlue">
                <div class="w-full aspect-[4/6]">
                    <img class="w-full aspect-[4/6] object-cover" src={{ $film->cover_image_url ?? asset('gudangfilm-logo.png') }} alt={{ $film->title }}>
                </div>
                <h1 class="w-full text-center mt-3 text-xs lg:text-sm">{{ $film->title }} ({{ $film->release_year }})</h1>
                <h4 class="text-xs text-gray-400">{{ $film->release_year }}</h4>
            </a>
        @endforeach
    </div>
</div>