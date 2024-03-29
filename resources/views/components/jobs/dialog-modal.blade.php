@props(['id' => null, 'maxWidth' => null])

<x-catalyst::modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4">
        <div class="text-lg">
            {{ $title }}
        </div>

        <div class="mt-4">
            {{ $content }}
        </div>
    </div>

    <div class="px-6 py-4 bg-neutral text-right">
        {{ $footer }}
    </div>
</x-catalyst::modal>
