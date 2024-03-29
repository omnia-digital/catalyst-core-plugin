@props([
'preview' => false,
'alt' => null
])

<div {{ $attributes->merge(['class' => 'flex items-center'])->only('class') }}>
    @if ($preview)
        <span class="h-20 w-20 rounded-full overflow-hidden bg-gray-100">
            <img src="{{ $preview }}" alt="{{ $alt }}">
        </span>
    @endif

    <div x-data="{ focused: false }">
        <span class="ml-5 rounded-md">
            <input @focus="focused = true" @blur="focused = false" class="sr-only"
                   type="file" {{ $attributes->wire('model') }} {{ $attributes->only('id') }}>
            <label for="{{ $attributes->only('id')->first() }}"
                   :class="{ 'outline-none border-blue-300 shadow-outline-blue': focused }"
                   class="cursor-pointer py-2 px-3 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 hover:text-gray-500 active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                Change
            </label>
        </span>
    </div>
</div>
