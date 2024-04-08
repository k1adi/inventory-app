<thead>
    <tr class="border-b-2">
        @foreach ($columns as $column)
            <th class="px-6 py-3 text-left font-medium text-black dark:text-white">{{ $column }}</th>
        @endforeach
    </tr>
</thead>