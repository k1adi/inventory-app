<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-3">
                <label>Total Item: {{ $items->count() }} </label>
    
                <a href="{{ route('item.create') }}">Tambah Item</a>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-table-layout>
                        <x-table-thead :columns="['No', 'Nama', 'Kategori', 'Qty', 'Action']" />
                        <tbody>
                            @foreach ($items as $item)
                                <tr class="border-b">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $item->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $item->category->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $item->qty }}
                                    </td>
                                    <td>
                                        <div class="flex justify-start gap-4">
                                            <a href="{{ route('item.edit', $item->id) }}">Edit</a>
                                            <form action="{{ route('item.destroy', $item) }}" method="POST" class="">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">Hapus</button>
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
