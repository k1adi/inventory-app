<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Catatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Tambah Catatan') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Pencatatan inventori setiap item beserta lokasinya.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('inventory.store') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('post')

                            <div>
                                <x-input-label for="item_id" :value="__('Item')" />
                                <x-select-option id="item_id" name="item_id" required>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}"> 
                                            ({{ $item->code }}) - {{ $item->name }}
                                        </option>
                                    @endforeach
                                </x-select-option>
                                <x-input-error class="mt-2" :messages="$errors->get('item_id')" />
                            </div>

                            <div>
                                <x-input-label for="location_id" :value="__('Lokasi Item')" />
                                <x-select-option id="location_id" name="location_id" required>
                                    @foreach ($locations as $item)
                                        <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                    @endforeach
                                </x-select-option>
                                <x-input-error class="mt-2" :messages="$errors->get('location_id')" />
                            </div>
                            
                            <div>
                                <x-input-label for="qty" :value="__('Qty Item')" />
                                <x-text-input id="qty" name="qty" type="text" pattern="[0-9]*" class="mt-1 block w-full" :value="old('qty')" required autocomplete="qty" />
                                <x-input-error class="mt-2" :messages="$errors->get('qty')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Tambah.') }}</x-primary-button>
                    
                                @if (session('status') === 'inventory-success')
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
