<x-layout :authed="false">
    <div class="flex items-center justify-center" style="min-height: calc(100vh);">
        <form action="/add-user" method="POST" 
            class="flex flex-col  bg-darkOcean px-16 py-10 lg:px-32 rounded-3xl lg:w-2/5"
            style="transform: translateY(-10%);">
            @csrf
            <h1 class="text-center font-bold text-3xl mb-1">Register</h1>
            <p class="mb-7 text-center">Already have an account? <a href="/login" class="font-bold text-blue-300">Log In</a></p>
            <div class=" md:w-full my-1">
                <label for="email">Email</label><br>
                <input type="text" id="email" name="email" value="{{ old('email') }}" class="text-black w-full rounded-lg p-1 box-border text-md"
                    style="border: 2px solid #ccc;">
                @error('email')
                    <div class="text-red-500 w-full">{{ $message }}</div>
                @enderror
            </div>
            <div class="md:w-full my-1">
                <label for="username">Username</label><br>
                <input type="text" id="username" name="username" value="{{ old('username') }}" class="text-black w-full rounded-lg p-1 box-border text-md"
                    style="border: 2px solid #ccc;">
                @error('username')
                    <div class="text-red-500 w-full">{{ $message }}</div>
                @enderror
            </div>
            <div class="md:w-full my-1">
                <label for="firstname">First Name</label><br>
                <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" class="text-black w-full rounded-lg p-1 box-border text-md"
                    style="border: 2px solid #ccc;">
                @error('firstname')
                    <div class="text-red-500 w-full">{{ $message }}</div>
                @enderror
            </div>
            <div class="md:w-full my-1">
                <label for="lastname">Last Name</label><br>
                <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" class="text-black w-full rounded-lg p-1 box-border text-md"
                    style="border: 2px solid #ccc;">
                @error('lastname')
                    <div class="text-red-500 w-full">{{ $message }}</div>
                @enderror
            </div>
            <div class="md:w-full my-1">
                <label for="password">Password</label><br>
                <input type="text" id="password" name="password" value="{{ old('password') }}" class="text-black w-full rounded-lg p-1 box-border text-md"
                    style="border: 2px solid #ccc;">
                @error('password')
                    <div class="text-red-500 w-full">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex justify-center">
                <button type="submit"
                    class="mt-7 bg-gray-500 lg:w-1/3 md:w-2/3 py-2 rounded-2xl font-semibold">Register</button>
            </div>
        </form>
        <div>
            <script src='js/register.js'></script>
</x-layout>
