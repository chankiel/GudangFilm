<div class="my-5">
    <x-search-bar></x-search-bar>
    <div class="flex flex-wrap justify-center lg:justify-center gap-5 gap-y-5 p-0 px-4 lg:px-10 m-0 list-none mt-4">
        @foreach ($films as $film)
            <a href="/films/{{ $film->slug }}" class="transition-transform duration-300 ease-in-out transform hover:scale-90 min-w-40 p-3 box-bordertext-white 
                film flex flex-col justify-center items-center max-w-48 bg-gray-900 rounded-xl hover:bg-midBlue">
                <div>
                    <img class="w-full" src={{ $film->cover_image_url }} alt={{ $film->title }}>
                </div>
                <h1 class="text-softWhite truncate w-full text-center mt-3">{{ $film->title }} ({{ $film->release_year }})</h1>
                <h4 class="text-xs text-gray-400">{{ $film->release_year }}</h4>
            </a>
        @endforeach
    </div>
    <div class="my-5 mx-3">
        {{ $films->links() }}
    </div>
</div>