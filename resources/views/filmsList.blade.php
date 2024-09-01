<x-layout :authed="$authed">
    <div class="m-1 lg:px-40 md:px-24 px-4">
        @php
            $query = request()->query('search');
        @endphp
        <h1 class="text-3xl font-bold my-6">{{ $title }}</h1>
        @if ($query)
            <h1 class="mb-2 text-lg">Search results for: <span class="font-bold ml-2">{{ $query }}</span></h1>
        @endif
        <x-search-bar></x-search-bar>
    </div>
    @if ($films->isEmpty())
        <div class="flex items-center justify-center" style="min-height: calc(100vh - 300px);">
            @if ($query)
                <h1 class="text-2xl font-semibold">Oops, No Films Found!</h1>
            @else
                <h1 class="text-2xl font-semibold">No Films Available</h1>
            @endif
        </div>
    @else
        <div class="flex items-center justify-center" style="min-height: calc(100vh - 300px);">
            <x-films-slide :films="$films"></x-films-slide>
        </div>
        <div class="sticky bottom-0">
            {{ $films->links() }}
        </div>
    @endif
</x-layout>
