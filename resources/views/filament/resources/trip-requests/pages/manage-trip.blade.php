<x-filament::page>

<div class="space-y-6">

    {{-- Trip Header --}}
    <div class="bg-white rounded-2xl shadow p-6">

        <div class="flex justify-between items-start">

            <div>
                <h2 class="text-2xl font-bold">
                    {{ $this->record->package?->name ?? 'Custom Trip' }}
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Ref: {{ $this->record->reference_code }}
                </p>

                <p class="text-sm text-gray-500">
                    {{ $this->record->arrival_date->format('M d, Y') }}
                    →
                    {{ $this->record->end_date->format('M d, Y') }}
                </p>
            </div>

            <div>
                <span class="px-3 py-1 rounded-full text-sm
                    @if($this->record->status === 'quote_requested') bg-yellow-100 text-yellow-700
                    @elseif($this->record->status === 'confirmed') bg-green-100 text-green-700
                    @else bg-gray-100 text-gray-700
                    @endif
                ">
                    {{ ucfirst(str_replace('_', ' ', $this->record->status)) }}
                </span>
            </div>

        </div>

    </div>

@foreach ($this->record->itineraries as $day)

<div class="border rounded-xl p-5 mb-6 bg-white shadow-sm">

    <h3 class="font-semibold text-lg mb-4">
        Day {{ $day->day_number }}
        — {{ $day->destination?->name }}
    </h3>

    {{-- Stay Vendor --}}
    <div class="mb-4">
        <label class="font-medium">Stay Vendor</label>

        <select
            wire:change="updateStayVendor({{ $day->id }}, $event.target.value)"
            class="w-full border rounded p-2 mt-1"
        >
            <option value="">Select Vendor</option>

            @foreach($vendors as $id => $name)
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

            <div class="border p-3 rounded bg-gray-50">

                <div class="font-medium mb-2">
                    {{ $activity->activity?->name }}
                </div>

                <select
                    wire:change="updateActivityVendor({{ $activity->id }}, $event.target.value)"
                    class="w-full border rounded p-2"
                >
                    <option value="">Select Vendor</option>

                    @foreach($vendors as $id => $name)
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
