@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'inline-flex items-center px-1 pt-1 border-b-4 border-rounded border-[#5CFFAB] text-md font-medium leading-5 text-green-600 focus:outline-none focus:border-green-600 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-4 border-rounded border-transparent text-md font-medium leading-5 text-gray-700 hover:text-green-600 hover:border-green-400 focus:outline-none focus:text-green-600 focus:border-green-400 rounded-t transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
