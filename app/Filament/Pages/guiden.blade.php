<x-filament::page>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">

        @foreach ($this->parts as $part)

        <div class="bg-white rounded-xl shadow p-2 text-center">

            <img
                src="{{ asset('storage/'.$part->part_image) }}"
                class="w-full h-32 object-contain rounded">

            <p class="text-xs mt-2 font-semibold">
                {{ $part->part_name }}
            </p>

        </div>

        @endforeach

    </div>

</x-filament::page>