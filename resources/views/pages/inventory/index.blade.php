<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-3">
                <label>Total Catatan Inventori: {{ $inventories->count() }} </label>
    
                <a href="{{ route('inventory.create') }}">Tambah Catatan</a>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-table-layout>
                        <x-table-thead :columns="['No', 'Kode', 'Item', 'Lokasi', 'Qty', 'Waktu', 'Action']" />
                        <tbody>
                            @foreach ($inventories as $item)
                                <tr class="border-b">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $item->item_code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $item->item_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $item->location->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $item->qty }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $item->updated_at ? $item->updated_at : $item->created_at }}
                                    </td>
                                    <td>
                                        <div class="flex justify-start gap-4">
                                            <a href="{{ route('inventory.edit', $item->id) }}">Edit</a>
                                            <form action="{{ route('inventory.destroy', $item) }}" method="POST" class="">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus catatan ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-table-layout>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
