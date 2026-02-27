<x-filament::page>

{{-- HEADER CARD --}}
<x-filament::section>

    <h2 class="text-xl font-bold">
        {{ $this->record->package?->name ?? 'Trip' }}
    </h2>

    <p class="text-sm text-gray-500">
        Ref: {{ $this->record->reference_code }}
    </p>

    <p class="text-sm">
        {{ $this->record->arrival_date->format('M d, Y') }}
        →
        {{ $this->record->end_date->format('M d, Y') }}
    </p>

</x-filament::section>


@if($this->record->status === 'quote_requested')

<div class="rounded-lg border border-warning-300 bg-warning-50 px-4 py-3 flex items-center gap-3 mb-6">

    <x-heroicon-m-exclamation-triangle class="w-5 h-5 text-warning-600"/>

    <div class="text-sm">
        <span class="font-semibold text-warning-800">
            Quote Requested
        </span>
        <span class="text-warning-700">
            — Prepare pricing for this trip.
        </span>
    </div>

</div>

@endif


{{-- ✅ PRICING PANEL --}}
{{ $this->form }}


{{-- ITINERARY --}}
@foreach ($this->record->itineraries as $day)

<x-filament::section
    :heading="'Day '.$day->day_number.' — '.$day->destination?->name"
    collapsible
>

    {{-- Stay Vendor --}}
    <div class="mb-4">
        <label class="text-sm font-medium">Stay Vendor</label>

        <x-filament::input.wrapper>
            <select
                wire:change="updateStayVendor({{ $day->id }}, $event.target.value)"
                class="fi-select-input w-full"
            >
                <option value="">Select Vendor</option>

                @foreach($this->vendors as $id => $name)
                    <option value="{{ $id }}"
                        @selected($day->stay_vendor_id == $id)>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </x-filament::input.wrapper>
    </div>


    {{-- Activities --}}
    <div class="space-y-3">

        @foreach ($day->activities as $activity)

        <x-filament::card>

            <div class="font-medium mb-2">
                {{ $activity->activity?->name }}
            </div>

            <x-filament::input.wrapper>
                <select
                    wire:change="updateActivityVendor({{ $activity->id }}, $event.target.value)"
                    class="fi-select-input w-full"
                >
                    <option value="">Select Vendor</option>

                    @foreach($this->vendors as $id => $name)
                        <option value="{{ $id }}"
                            @selected($activity->vendor_id == $id)>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </x-filament::input.wrapper>

        </x-filament::card>

        @endforeach

    </div>

</x-filament::section>

@endforeach

</x-filament::page>
