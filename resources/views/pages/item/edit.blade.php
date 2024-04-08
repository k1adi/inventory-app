<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Perbarui Item') }}
                            </h2>
                        </header>

                        <form method="post" action="{{ route('item.update', $item) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('PUT')

                            <div>
                                <x-input-label for="code" :value="__('Kode Item')" />
                                <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code', $item->code)" required autofocus autocomplete="code" />
                                <x-input-error class="mt-2" :messages="$errors->get('code')" />
                            </div>

                            <div>
                                <x-input-label for="name" :value="__('Nama Item')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $item->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                            
                            <div>
                                <x-input-label for="qty" :value="__('Qty Item')" />
                                <x-text-input id="qty" name="qty" type="text" pattern="[0-9]*" class="mt-1 block w-full" :value="old('qty', $item->qty)" required autofocus autocomplete="qty" />
                                <x-input-error class="mt-2" :messages="$errors->get('qty')" />
                            </div>

                            <div>
                                <x-input-label for="category" :value="__('Kategori Item')" />
                                <select id="category" name="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @foreach ($categories as $option)
                                        <option value="{{ $option->id }}" {{ $option->id == $item->category_id  ? 'selected' : '' }}>
                                            {{ $option->name }} 
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Tambah.') }}</x-primary-button>
                    
                                @if (session('status') === 'item-updated')
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
