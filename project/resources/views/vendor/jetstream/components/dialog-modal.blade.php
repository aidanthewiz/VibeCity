@props(['id' => null, 'maxWidth' => null])

<x-jet-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4 bg-gray-900">
        <div class="text-lg text-white">
            {{ $title }}
        </div>

        <div class="mt-4 text-gray-200">
            {{ $content }}
        </div>
    </div>

    <div class="px-6 py-4 bg-gray-700 text-right">
        {{ $footer }}
    </div>
</x-jet-modal>
