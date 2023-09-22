<!-- //hier komt de base / nav bar en dergelijke -->
<x-app-layout>
    <x-slot name="head">
        @vite('resources/css/app.css')
        <meta name="ai_request_route" content="{{ route('doAIprompt')}}">
        <meta name="csrf_token" content="{{ csrf_token() }}">
    </x-slot>
<body>

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 container mx-auto py-12">
    <div>
        <h2 class="mb-4 text-4xl font-extrabold leading-none tracking-tight mt-10 text-gray-900 md:text-5xl lg:text-6xl dark:text-white"><span class="text-blue-500 dark:text-blue-500">Genereer jouw samenvatting:</h2>
    </div>
    
    <form id="AIprompt" action="{{route('doAIprompt')}}" method="post">
        @csrf
        <div class="mb-6">
            <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Onderwerp(en) (gescheiden door een komma)</label>
            <input name="subject" type="text" id="subject" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
        <div class="mb-6">
            <label for="exclude" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sluit uit:</label>
            <input name="exclude" type="text" id="exclude" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
        <div class="mb-6">
            <label for="age" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Voor personen in de leeftijd:</label>
            <input name="age" type="number" id="age" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
        <div class="mb-6">
            <label for="target" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Voor wie is het?</label>
            <select name="target" id="target" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="student">Student</option>
                <option value="friend">Vriend</option>
                <option value="teacher">Docent</option>
                <option value="coach">Coach</option>
            </select>
        </div>
        <div class="mb-6">
            <label for="experience" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Wat is de ervaring van de lezer?</label>
            <select name="experience" id="experience" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="beginner">Beginner</option>
                <option value="average">Gemiddeld</option>
                <option value="advanced">Gevorderd</option>
            </select>
        </div>
        <div class="mb-6">
            <label for="time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">In hoeveel tijd moet het te lezen zijn?</label>
            <select name="time" id="time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="0-10">0 - 10 minuten</option>
                <option value="10-15">10 - 15 minuten</option>
                <option value="15-20">15 - 20 minuten</option>
                <option value="20">> 20 minuten</option>
            </select>
        </div>

        <x-button>
            <input type="submit" value="Genereer mijn samenvatting">
        </x-button>
        <div id="summary"></div>
    </form>
</div>
<script src="{{asset('api.js')}}"></script>
<script>
    doAIprompt();
</script>

</x-app-layout>