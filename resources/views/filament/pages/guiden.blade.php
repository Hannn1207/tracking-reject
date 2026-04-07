<x-filament::page>

    <div class="grid grid-cols-3 gap-6">

        @foreach ($parts as $part)

        <div class="border rounded-xl p-4 text-center">

            <img
                src="{{ asset('storage/'.$part->part_image) }}"
                class="w-full h-32 object-contain">

            <p class="mt-2 font-semibold">
                {{ $part->part_name }}
            </p>

        </div>

        @endforeach

    </div>

</x-filament::page>