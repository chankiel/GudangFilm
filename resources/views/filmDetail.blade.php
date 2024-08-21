<x-layout :authed="$authed">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <div id="main-content" class="flex items-center justify-center {{ session('success') ? 'blur' : '' }} relative"
        style="min-height: calc(100vh - 100px);">
        <div class="w-3/4 p-5 text-white">
            @if ($bought)
                <video class="w-full mb-5 mx-auto" controls>
                    <source src="{{ $film->video_url }}" type="video/mp4">
                </video>
            @endif
            <div class="flex mb-3">
                <img src="{{ $film->cover_image_url }}" alt="" class="">
                <div class="ml-4 w-full">
                    <h1 class="text-3xl font-semibold">{{ $film->title }}</h1>
                    <h3 class="text-sm mb-3 mt-2">{{ implode(' | ', $genres) }} - {{ $formattedDuration }}</h3>
                    <h2 class="mb-6 text-xl text-yellow-500 font-bold">Rp.{{ number_format($film->price, 0, ',', '.') }}
                    </h2>
                    <div class="flex gap-3">
                        @if (!$bought)
                            <form action="{{ url('buy-film/' . $film->id) }}" method="POST" class="w-1/2">
                                @csrf
                                <button
                                    class="rounded-2xl w-full p-4 border-4 font-bold bg-orange-400 text-darkOcean">Buy
                                    Film</button>
                            </form>
                            @if (session('error'))
                                <div class="text-red-500 w-full error h-5" id="error-user">{{ session('error') }}</div>
                            @endif
                        @else
                        @endif
                        @if (!$wished)
                            <form action="{{ url('wish-film/' . $film->id) }}" method="POST" class="w-1/2">
                                @csrf
                                <button class="rounded-2xl w-full p-4 border-4 font-bold bg-blue-300 text-darkOcean">Add
                                    to
                                    WishList</button>
                            </form>
                        @else
                            <form action="{{ url('unwish-film/' . $film->id) }}" method="POST" class="w-1/2">
                                @csrf
                                <button class="rounded-2xl w-full p-4 border-4 font-bold bg-red-600 text-white">Remove
                                    from
                                    WishList</button>
                            </form>
                        @endif
                    </div>
                    <div class="flex gap-3 mt-3">
                        <h1 class="hidden md:flex md:justify-center items-center text-2xl bg-gray-700 rounded-2xl w-12">
                            {{ $film->avg_rating ?? 0 }}</h1>
                        <div class="cursor-pointer">
                            @for ($i = 1; $i <= 5; $i++)
                                <form action="{{ url('rate-film/' . $film->id . '/'.$i) }}" method="POST"
                                    class="inline-block" id="star-{{ $i }}">
                                    @csrf
                                    <button class="fa fa-star" type="submit" {{ !$bought ? 'disabled' : ''}}></button>
                                </form>
                            @endfor
                            <p class="text-sm hidden md:block">{{ $film->count_rating }} votes</p>
                        </div>
                        <h2 class="font-bold">Your rating: {{ $rating ?? 0 }}</h2>
                    </div>
                </div>
            </div>
            <h3 class="text-gray-300 text-sm">Description</h3>
            <p class="text-sm md:text-base">{{ $film->description }}</p>
            <h3 class="mt-3 text-sm text-gray-300">Director</h3>
            <p>{{ $film->director }}</p>
            <h3 class="mt-3 text-sm text-gray-300">Release Year</h3>
            <p class="border-b pb-8">{{ $film->release_year }}</p>

            <form class="bg-bgBlue flex gap-4 my-8" action="{{ url('comment-film/' . $film->id) }}" method="POST">
                @csrf
                <div>
                    <span class="material-symbols-outlined w-full">account_circle</span>
                </div>
                <div class="w-full">
                    <input type="text" class="w-full bg-bgBlue border h-24 pl-3" placeholder="Join the discussion!" name="comment" required>
                </div>
                <button class="rounded-2xl w-1/5 p-3 border-4 font-bold bg-darkOcean text-white {{ !$bought ? 'cursor-not-allowed' : ''}}" {{ !$bought ? 'disabled' : ''}}>Post Comment</button>
            </form>
            <div class="border-b">{{ $commentsCount }} Comments</div>
            @foreach ($comments as $comment)
                <x-comment :comment="$comment"></x-comment>
            @endforeach
        </div>
    </div>


    @if (session('success'))
        <div id="succ-modal" class="fixed inset-0 flex items-center justify-center ">
            <div class="bg-darkOcean rounded-lg shadow-lg w-3/4 md:w-1/2 lg:w-1/3 p-6 relative">
                <span id="closeBtn"
                    class="absolute top-2 right-2 text-gray-500 hover:text-black cursor-pointer text-xl">&times;</span>
                <h2 class="text-2xl font-semibold mb-4">Transaction Success!</h2>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif
</x-layout>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('succ-modal');
        const closeBtn = document.getElementById('closeBtn');
        const main = document.getElementById('main-content');
        let rating = @json($rating);
        let bought = @json($bought);

        if (modal) {
            closeBtn.onclick = () => {
                modal.classList.add('hidden');
                main.classList.remove('blur');
            }

            window.onclick = function(event) {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                    main.classList.remove('blur');
                }
            }
        }

        if(!bought){
            return;
        }

        for (let i = 1; i <= 5; i++) {
            const star = document.getElementById('star-' + i);
            if(i<=rating){
                star.classList.add("text-yellow-500");
            }
            star.addEventListener('mouseover', function() {
                for (let j = 1; j <= i; j++) {
                    const starBefore = document.getElementById('star-' + j);
                    starBefore.classList.add("text-yellow-500");
                }

                for (let j = i+1; j <= 5; j++) {
                    const starBefore = document.getElementById('star-' + j);
                    starBefore.classList.remove("text-yellow-500");
                }
            })

            star.addEventListener('mouseout', function() {
                for (let j = 1; j <= rating; j++) {
                    const starBefore = document.getElementById('star-' + j);
                    starBefore.classList.add("text-yellow-500");
                }
                for (let j = rating+1; j <= 5; j++) {
                    const starBefore = document.getElementById('star-' + j);
                    starBefore.classList.remove("text-yellow-500");
                }
            })
        }
    })
</script>
