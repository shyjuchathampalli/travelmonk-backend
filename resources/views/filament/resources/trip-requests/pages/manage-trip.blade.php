<x-filament::page>

<h2 class="text-xl font-bold mb-6">
    Trip {{ $this->trip->reference_code }}
</h2>

@foreach ($this->trip->itineraries as $day)

<div class="border rounded-xl p-5 mb-6 bg-white">

    <h3 class="font-semibold text-lg mb-4">
        Day {{ $day->day_number }}
        — {{ $day->destination?->name }}
    </h3>

    {{-- Stay Vendor --}}
    <div class="mb-4">
        <label class="font-medium">Stay Vendor</label>

        <select wire:change="updateStayVendor({{ $day->id }}, $event.target.value)"
                class="w-full border rounded p-2 mt-1">

            <option value="">Select Vendor</option>

            @foreach($this->vendors as $id => $name)
                <option value="{{ $id }}"
                    @selected($day->stay_vendor_id == $id)>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Activities --}}
    <div class="space-y-3">

        @foreach ($day->activities as $activity)

            <div class="border p-3 rounded">

                <div class="font-medium">
                    {{ $activity->activity?->name }}
                </div>

                <select wire:change="updateActivityVendor({{ $activity->id }}, $event.target.value)"
                        class="w-full border rounded p-2 mt-2">

                    <option value="">Select Vendor</option>

                    @foreach($this->vendors as $id => $name)
                        <option value="{{ $id }}"
                            @selected($activity->vendor_id == $id)>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>

            </div>

        @endforeach

    </div>

</div>

@endforeach

</x-filament::page>
