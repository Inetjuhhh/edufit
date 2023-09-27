<x-app-layout>
    <x-slot name="head">
        @vite('resources/css/app.css')

    </x-slot>
<body>

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 container mx-auto py-12">
    <div>
        <h2 class="mb-4 text-4xl font-extrabold leading-none tracking-tight mt-10 text-gray-900 md:text-5xl lg:text-6xl dark:text-white"><span class="text-blue-500 dark:text-blue-500">Jouw samenvatting</h2>
    </div>
    <div class="summary">
        {!! nl2br(e($summary)) !!}
    </div>


</x-app-layout>