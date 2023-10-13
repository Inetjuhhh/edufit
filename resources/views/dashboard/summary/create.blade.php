<!-- //hier komt de base / nav bar en dergelijke -->
<x-app-layout>
    <x-slot name="head">
        @vite('resources/css/app.css')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="ai_request_route" content="{{ route('doAIprompt') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </x-slot>
<body>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 container mx-auto py-12">
        <div>
            <h2 class="mb-4 text-4xl font-extrabold leading-none tracking-tight mt-10 text-gray-900 md:text-5xl lg:text-6xl dark:text-white"><span class="text-blue-500 dark:text-blue-500">Genereer jouw samenvatting:</h2>
        </div>
        
        <form id="ai_form">
            @csrf
            <input type="hidden" id="ai_question" name="ai_question" value="Wanneer begint de zomer?">

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
     
        </form>
        <textarea id="ai_response" cols="100" rows="10"></textarea>
    </div>
    <script>
        document.getElementById("ai_form").addEventListener("submit", function(event) {
            event.preventDefault();
            const subject = document.getElementById("subject").value;
            const exclude = document.getElementById("exclude").value;
            const age = document.getElementById("age").value;
            const target = document.getElementById("target").value;
            const experience = document.getElementById("experience").value;
            const time = document.getElementById("time").value;
            const prompt = `
                Maak een samenvatting van interessante theorie.
                Het moet in ieder geval ingaan op de volgende onderwerp(en): ${subject}.
                Sluit het volgende uit: niets (default), ${exclude}.
                Het resultaat is voor personen in de leeftijd ${age} op het niveau ${target}.
                Het kennisniveau van de personen is ${experience}.
                Het moet te lezen zijn in ongeveer ${time} en begint met een inhoudsopgave. Daarna volgt een inleiding over het onderwerp en is vervolgens ingedeeld in hoofdstukken, waaronder puntsgewijs belangrijke informatie is uitgewerkt. Na elk hoofdstuk volgen één of meerdere voorbeelden van de toegepaste kennis. De samenvatting eindigt met een puntsgewijze samenvatting van de hoofdpunten.
                `;
            
            // const prompt = document.getElementById("ai_question").value;
            const ai_request_route = document.querySelector('meta[name="ai_request_route"]').content;
            const csrf_token = document.querySelector('meta[name="csrf-token"]').content;

            fetch(ai_request_route, {
                method: 'POST',
                headers:{
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf_token, 
                },
                body: {
                    model: "gpt-3.5-turbo",
                    messages: [{role: "user", content: prompt}],
                    stream: true,
                    temperature: 0 
                },
            })
            .then(response => response.body)
            .then(async body => {
                // maak een tunnel. we krijgen bytes terug, wordt gedecode. Getreader leest het.
                const reader = body.pipeThrough(new TextDecoderStream()).getReader();
                let partialChunk = '';

                while (true) {
                    // const result = await reader.read();
                    // const done = result.done;
                    // const value = result.value;

                    //maak twee variabelen uit de functie read (die heeft de attributen done en value)
                    const { done, value } = await reader.read();

                    if (done) {
                        if (partialChunk) {
                            console.log('Full chunk:', partialChunk);
                        }
                        break;
                    }

                    const text = partialChunk + value;
                    const chunks = text.split('\n');

                    for (let i = 0; i < chunks.length - 1; i++) {
                        if (chunks[i].trim().startsWith('data: ')) {
                            if(chunks[i].trim().substring(6) == '[DONE]'){
                                console.log('DONE');
                                break;
                            }
                            let dataChunk = JSON.parse(chunks[i].trim().substring(6));
                            let content = dataChunk.choices[0].delta.content;
                            if(dataChunk.choices[0].finish_reason == 'stop'){
                                break;
                            }
                            document.getElementById('ai_response').value += content;
                            console.log(dataChunk);
                        }
                    }

                    partialChunk = chunks[chunks.length - 1];
                }
                console.log('Response fully received');

            
            })
                
            
        });
    </script>

    </x-app-layout>