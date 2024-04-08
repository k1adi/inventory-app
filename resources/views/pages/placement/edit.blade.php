<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Catatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Perbarui Catatan') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Pengeditan catatan inventori lokasi item beserta jumlahnya.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('placement_item.update', $placementItem) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('PUT')

                            <div>
                                <x-input-label :value="__('Item')" />
                                <x-text-input type="hidden" name="item_id" value="{{ $placementItem->item_id }}" />
                                <x-text-input type="text" class="mt-1 block w-full" value="({{ $placementItem->item_code }}) - {{ $placementItem->item_name }}" readonly disabled/>
                                <x-input-error class="mt-2" :messages="$errors->get('item_id')" />
                            </div>

                            <div>
                                <x-input-label for="location_id" :value="__('Lokasi Item')" />
                                <x-select-option id="location_id" name="location_id" required>
                                    @foreach ($locations as $item)
                                        <option value="{{ $item->id }}"> 
                                            {{ $item->name }} 
                                        </option>
                                    @endforeach
                                </x-select-option>
                                <x-input-error class="mt-2" :messages="$errors->get('location_id')" />
                            </div>
                            
                            <div>
                                <x-input-label for="qty" :value="__('Qty Item')" />
                                <x-text-input id="qty" name="qty" type="text" pattern="[0-9]*" class="mt-1 block w-full" :value="old('qty', $placementItem->qty)" required autocomplete="qty" />
                                <x-input-error class="mt-2" :messages="$errors->get('qty')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Edit.') }}</x-primary-button>
                    
                                @if (session('status') === 'placement-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600"
                                    >{{ __('Berhasil.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
