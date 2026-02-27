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


@if($this->record->status === 'quote_requested')

<div class="bg-white rounded-2xl shadow p-6">

    <h3 class="text-lg font-semibold mb-4">
        Pricing
    </h3>

    <div class="grid grid-cols-3 gap-4">

        <div>
            <label class="text-sm">Transport Cost</label>
            <input type="number" wire:model="transport_cost"
                class="w-full border rounded-lg p-2 mt-1">
        </div>

        <div>
            <label class="text-sm">Margin %</label>
            <input type="number" wire:model="margin_percent"
                class="w-full border rounded-lg p-2 mt-1">
        </div>

        <div>
            <label class="text-sm">Final Price</label>
            <input type="number" wire:model="final_price"
                class="w-full border rounded-lg p-2 mt-1 bg-gray-100"
                readonly>
        </div>

    </div>

</div>

@endif

@foreach ($this->record->itineraries as $day)

<div class="bg-white rounded-2xl shadow p-6">

    <h3 class="text-lg font-semibold mb-4">
        Day {{ $day->day_number }} — {{ $day->destination?->name }}
    </h3>

    {{-- Stay --}}
    <div class="mb-6">

        <div class="flex justify-between items-center mb-2">
            <span class="font-medium">Stay Vendor</span>
        </div>

        <select
            wire:change="updateStayVendor({{ $day->id }}, $event.target.value)"
            class="w-full border rounded-lg p-2"
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
    <div class="space-y-4">

        @foreach ($day->activities as $activity)

            <div class="bg-gray-50 p-4 rounded-xl">

                <div class="font-medium mb-2">
                    {{ $activity->activity?->name }}
                </div>

                <select
                    wire:change="updateActivityVendor({{ $activity->id }}, $event.target.value)"
                    class="w-full border rounded-lg p-2"
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
