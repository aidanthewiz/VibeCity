<div class="md:grid md:grid-cols-3 md:gap-6 bg-gradient-to-t from-red-700 to-yellow-500 rounded" {{ $attributes }}>
    <!-- set title and description of form -->
    <x-jet-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-jet-section-title>

    <!-- set content for form -->
    <div class="mt-5 md:mt-0 md:col-span-2 gap-0 p-1">
        <div class="bg-gray-900 shadow-md h-full rounded">
            {{ $content }}
        </div>
    </div>
</div>
