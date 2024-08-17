@props([
    'authed'=>null,
    'logReg' => false,
])

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

@if (!$logReg)
<header class="bg-darkOcean shadow text-softWhite py-4">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <a href="/" class="text-xl font-semibold">GudangFilm</a>
        <nav class="hidden md:flex items-center space-x-6">
            <a href="/" class="hover:text-gray-500">Home</a>
            <a href="/myfilms" class="hover:text-gray-900">My Films</a>
            @if ($authed)
            <div>Rp.{{ $authed->balance }}</div>
            <a href="#"><span class="material-symbols-outlined">account_circle</span></a>
            @else
            <a href="/login" class="bg- px-3 py-2 rounded-2xl bg-softBlue border-2 border-softBlue hover:bg-darkOcean">Log In</a>
            @endif
        </nav>
        <a class="pt-1 md:hidden text-gray-600 hover:text-gray-900 focus:outline-none flex justify-center items-center">
            <svg class="" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </a>
    </div>
</header>
@endif


