<x-layout :authed="$authed">
    <div class="flex items-center justify-center" style="min-height: calc(100vh - 180px);">
        <div class="w-2/3">
            <h1 class="text-3xl font-bold my-6">My Films</h1>
            <x-films-slide :films="$films"></x-films-slide>
        </div>
    </div>
</x-layout>