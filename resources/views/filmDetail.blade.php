<x-layout :authed="$authed">
    <div id="main-content" class="flex items-center justify-center {{ session('success') ? 'blur':'' }}" style="min-height: calc(100vh - 100px);">
        <div class="w-3/4 pb-5 text-white">
            @if ($bought)
                <video class="w-full lg:mt-5 mb-5 mx-auto" controls>
                    <source src="{{ $film->video_url }}" type="video/mp4">
                </video>
            @endif
            <div class="flex mb-3">
                <img src="{{ $film->cover_image_url }}" alt="" class="">
                <div class="ml-4">
                    <h1 class="text-3xl font-semibold">{{ $film->title }}</h1>
                    <h3 class="text-sm mb-3 mt-2">{{ implode(' | ', $genres) }} - {{ $formattedDuration }}</h3>
                    <h2 class="mb-6 text-xl text-yellow-500 font-bold">Rp.{{ number_format($film->price, 0, ',', '.') }}</h2>
                    @if (!$bought)
                        <form action="{{ url('buy-film/'.$film->id) }}" method="POST">
                            @csrf
                            <button class="rounded-2xl w-full p-4 border-4 font-bold bg-blue-300 text-darkOcean">Beli Film</button>
                        </form>
                        @if(session('error'))
                            <div class="text-red-500 w-full error h-5" id="error-user">{{ session('error') }}</div>
                        @endif
                    @else

                    @endif
                </div>
            </div>
            <h3 class="text-gray-300 text-sm">Description</h3>
            <p class="text-sm md:text-base">{{ $film->description }}</p>
            <h3 class="mt-3 text-sm text-gray-300">Director</h3>
            <p>{{ $film->director }}</p>
            <h3 class="mt-3 text-sm text-gray-300">Release Year</h3>
            <p >{{ $film->release_year }}</p>
        </div>
    </div>
    @if(session('success'))
        <div id="succ-modal" class="fixed inset-0 flex items-center justify-center ">
            <div class="bg-darkOcean rounded-lg shadow-lg w-3/4 md:w-1/2 lg:w-1/3 p-6 relative">
                <span id="closeBtn" class="absolute top-2 right-2 text-gray-500 hover:text-black cursor-pointer text-xl">&times;</span>
                <h2 class="text-2xl font-semibold mb-4">Transaction Success!</h2>
                <p>Film berhasil dibeli!</p>
            </div>
        </div>
    @endif
</x-layout>
<script>
    document.addEventListener('DOMContentLoaded',()=>{
    const modal = document.getElementById('succ-modal');
    const closeBtn = document.getElementById('closeBtn');
    const main = document.getElementById('main-content');

    if(modal){
        closeBtn.onclick = ()=>{
            modal.classList.add('hidden');
            main.classList.remove('blur');
        }

        window.onclick = function(event){
            if(event.target === modal){
                modal.classList.add('hidden');
                main.classList.remove('blur');
            }
        }
    }
})
</script>