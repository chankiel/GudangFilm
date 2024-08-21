<x-layout :authed="$authed">
    <div class="m-1 lg:px-40 px-24">
        <h1 class="text-3xl font-bold my-6">{{ $title }}</h1>
        <x-search-bar></x-search-bar>
    </div>
    <div class="flex items-center justify-center" style="min-height: calc(100vh - 300px);">
            <x-films-slide :films="$films"></x-films-slide>
    </div>
    <div class="sticky bottom-0">
        {{ $films->links() }}
    </div>
</x-layout>