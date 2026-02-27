<x-filament::page>

    <h2 class="text-xl font-bold mb-4">
        Trip: {{ $this->trip->reference_code }}
    </h2>

    @foreach ($this->trip->itineraries as $day)
        <div class="border rounded p-4 mb-4">
            <h3 class="font-semibold">
                Day {{ $day->day_number }}
                - {{ $day->destination?->name }}
            </h3>

            <ul class="mt-2">
                @foreach ($day->activities as $activity)
                    <li>
                        {{ $activity->activity?->name }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach

</x-filament::page>
