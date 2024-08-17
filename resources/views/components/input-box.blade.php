<div class="lg:w-1/2 md:w-full my-1">
    
    <label for="{{ $name }}">{{ $slot }}</label><br>
    <input type="text" id="{{ $name }}" name="{{ $name }}" class="text-black w-full rounded-lg p-1 box-border text-md"
        style="border: 2px solid #ccc;">
    @error($name)
        <div class="text-red-500">{{ $message }}</div>
    @enderror
</div>
