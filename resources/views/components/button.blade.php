@props([
    'type' => 'button',
    'variant' => 'primary', // primary | secondary | danger
])

@php
$base = "px-4 py-2 rounded font-semibold focus:outline-none transition";
$styles = match($variant) {
    'primary' => "bg-blue-600 text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600",
    'secondary' => "bg-gray-200 text-gray-800 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600",
    'danger' => "bg-red-600 text-white hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600",
    default => "bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200",
};
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "$base $styles"]) }}>
    {{ $slot }}
</button>
