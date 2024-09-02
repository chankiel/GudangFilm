<div class="bg-bgBlue flex gap-4 my-8">
    <div class="">
        <span class="material-symbols-outlined w-full">account_circle</span>
    </div>
    <div class="w-full bg-bgBlue border min-h-24">
        <div class="flex gap-4 items-center py-2 px-3 bg-gray-300 text-black">
            <div>{{ $comment->user->username }}</div>
            <div class="flex items-center gap-1 text-xs"><span class="material-symbols-outlined">
                    schedule
                </span>{{ $comment->created_at->diffForHumans() }}</div>
            @if ($authed && $authed->id == $comment->user_id)
                <form method="POST" action="{{ url('uncomment-film/' . $comment->id) }}" class="h-6 ml-auto">
                    @csrf
                    <button class="h-full" type="submit">
                        <img src="{{ asset('delete.png') }}" alt="delete" class="ml-auto max-h-full">
                    </button>
                </form>
            @endif
        </div>
        <p class="pl-3 py-5">{{ $comment->comment }}</p>
    </div>
</div>
