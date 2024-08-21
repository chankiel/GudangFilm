<div class="bg-bgBlue flex gap-4 my-8">
    
    <div class="">
        <span class="material-symbols-outlined w-full">account_circle</span>
    </div>
    <div class="w-full bg-bgBlue border min-h-24">
        <div class="flex gap-4 items-center py-2 pl-3 bg-gray-300 text-black">
            <div class="">{{ $comment->user->username }}</div>
            <div class="flex items-center gap-1"><span class="material-symbols-outlined">
                schedule
                </span>{{ $comment->created_at->diffForHumans() }}</div>
        </div>
        <p class="pl-3 py-5">{{ $comment->comment }}</p>
    </div>
</div>