@props([
    'headers' => []
])

<table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 shadow rounded">
    <thead>
        <tr class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
            @foreach ($headers as $header)
                <th class="px-4 py-2 text-left">{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody class="text-gray-900 dark:text-gray-100">
        {{ $slot }}
    </tbody>
</table>
