<x-layout :authed="$authed">
    <div class="flex items-center justify-center" style="min-height: calc(100vh - 180px);">
        <div class="w-full">
            <x-films-slide :films="$films"></x-films-slide>
        </div>
    </div>
</x-layout>
