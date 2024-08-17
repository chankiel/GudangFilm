<x-layout :authed="false">
    <div class="flex items-center justify-center" style="min-height: calc(75vh);">
        <form
            class="flex flex-col bg-darkOcean px-16 py-10 lg:px-32 rounded-3xl lg:w-2/5"
            style="transform: translateY(-10%);">
            @csrf
            <h1 class="text-center font-bold text-3xl mb-1">Login</h1>
            <p class="text-center" id="register">Doesn't have an account? <a href="/register" class="font-bold text-blue-300">Register</a></p>
            <div class="text-red-500 w-full error h-5 mt-3" id="error-creds"></div>
            <div class=" md:w-full my-1">
                <label for="emailUsr">Email / Username</label><br>
                <input type="text" id="emailUsr" name="emailUsr" value="{{ old('emailUsr') }}" class="text-black w-full rounded-lg p-1 box-border text-md"
                    style="border: 2px solid #ccc;">
            </div>
            <div class="text-red-500 w-full error h-5" id="error-user"></div>
            <div class="md:w-full mb-1 mt-2">
                <label for="password">Password</label><br>
                <input type="text" id="password" name="password" value="{{ old('password') }}" class="text-black w-full rounded-lg p-1 box-border text-md"
                    style="border: 2px solid #ccc;">
            </div>
            <div class="text-red-500 w-full error h-5" id="error-pw"></div>
            <div class="flex justify-center">
                <button type="submit"
                    class="mt-7 bg-gray-500 lg:w-1/3 md:w-2/3 p-2 rounded-2xl font-semibold">Log In</button>
            </div>
        </form>
        <div>
            <script src='js/login.js'></script>
</x-layout>
