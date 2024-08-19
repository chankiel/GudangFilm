@props([
    'authed' => null,
    'logReg' => false,
])

<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
@if (!$logReg)

    <header class="bg-darkOcean shadow text-softWhite py-1 relative">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <img src="{{ asset('gudangfilm-logo.png') }}" alt="gudangfilm-logo" class="w-[100px]">
            <nav class="hidden md:flex items-center space-x-6">
                <a href="/" class="{{ request()->is('/')===true ? 'font-bold border-b-2':'hover:text-gray-500' }}">Home</a>
                <a href="/myfilms" class="{{ request()->is('myfilms')===true ?'font-bold border-b-2':'hover:text-gray-500' }}">My Films</a>
                @if ($authed)
                    <div>Rp. {{ number_format($authed->balance, 0, '', '.') }}</div>
                    <a href="#" class="relative group bg-darkOcean text-white px-4 rounded"><span
                            class="material-symbols-outlined">account_circle</span>
                        <div
                            class="absolute left-0 top-full w-24 bg-white border border-gray-300 shadow-lg rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <form class="p-3 text-darkOcean font-semibold" action="/logout-be">
                                <button type="submit">Logout</button>
                            </form>
                        </div>
                    </a>
                @else
                    <a href="/login"
                        class="bg- px-3 rounded-2xl bg-softBlue border-2 border-softBlue hover:bg-darkOcean py-2">Log In</a>
                @endif
            </nav>
            <button id="mobile-menu"
                class="relative group pt-1 md:hidden text-gray-600 hover:text-gray-900 focus:outline-none flex justify-center items-center">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
        <div id="mobile-dropdown"
            class=" z-10 hidden md:hidden absolute top-full left-0 w-full bg-darkOcean shadow-lg rounded-bl-2xl rounded-br-2xl transition-opacity opacity-0 duration-300 ease-in-out">
            <a href="/" class="block px-4 py-2 {{ request()->is('/')===true ? 'font-extrabold':'hover:bg-gray-100 hover:text-black' }}">Home</a>
            <a href="/myfilms" class="block px-4 py-2 {{ request()->is('myfilms')===true ? 'font-extrabold':'hover:bg-gray-100 hover:text-black' }}">My Films</a>
            @if ($authed)
                <div class="px-4 py-2 flex gap-5">
                    <span class="material-symbols-outlined">account_circle</span>
                    <h1>{{ $authed->username }}</h1>
                </div>
                <h2 class="px-4 py-2">Balance: Rp. {{ number_format($authed->balance, 0, '', '.') }}</h2>
                <form action="/logout-be" class="block px-4 py-2 hover:bg-gray-100 hover:text-black hover:cursor-pointer">
                    <button type="submit" class="w-full text-start pb-2">Logout</button>
                </form>
            @else
                <a href="/login" class="block px-4 py-2 hover:bg-gray-100 hover:text-black">Log In</a>
            @endif
        </div>
    </header>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const menuButton = document.getElementById('mobile-menu');
        const menuDropdown = document.getElementById('mobile-dropdown');
        const body = document.querySelector('main');

        menuButton.addEventListener('click', () => {
            if (menuDropdown.classList.contains('hidden')) {
                body.classList.toggle('blur');
                menuDropdown.classList.remove('hidden');
                setTimeout(() => {
                    menuDropdown.classList.remove('opacity-0');
                    menuDropdown.classList.add('opacity-100');
                }, 10);
            } else {
                body.classList.remove('blur');
                menuDropdown.classList.remove('opacity-100');
                menuDropdown.classList.add('opacity-0');
                setTimeout(() => {
                    menuDropdown.classList.add('hidden');
                }, 300);
            }
        });

        // Optional: Close the menu when clicking outside
        document.addEventListener('click', (event) => {
            if (!menuButton.contains(event.target) && !menuDropdown.contains(event.target)) {
                body.classList.remove('blur');
                menuDropdown.classList.remove('opacity-100');
                menuDropdown.classList.add('opacity-0');
                setTimeout(() => {
                    menuDropdown.classList.add('hidden');
                }, 300); // Match duration of the transition
            }
        });
    });
</script>
