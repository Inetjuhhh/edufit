<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function doAIprompt(Request $request)
    {
        $request->validate([
            //
        ]);
        $subject = $request->subject;
        $exclude = $request->exclude;
        $age = $request->age;
        $target = $request->target;
        $experience = $request->experience;
        $time = $request->time;
        $prompt =   "Maak een samenvatting van interessante theorie. " .
                    " Het moet in ieder geval ingaan op de volgende onderwerp(en):" . $subject . 
                    " . Sluit het volgende uit: niets(default), " . $exclude . 
                    ". Het resultaat is voor personen in de leeftijd ". $age . 
                    " op het niveau ". $target . 
                    ". Het kennisniveau van de personen is ". $experience . 
                    ". Het moet te lezen zijn in ongeveer " . $time . 
                    " en begint met een inhoudsopgave, daarna een inleiding over het onderwerp en is vervolgens ingedeeld in hoofdstukken, waaronder puntsgewijs belangrijke informatie is uitgewerkt. . Na elk hoofdstuk volgen één of meerdere voorbeelden van de toegepaste kennis. De samenvatting eindigt met een puntsgewijze samenvatting van de hoofdpunten.";
        
        $OPENAI_API_KEY = env('OPENAI_API_KEY');
        
        $client = new Client();

        // Make a POST request to the OpenAI API
        $response = $client->post('https://api.openai.com/v1/engines/davinci-codex/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            ],
            'json' => [
                'prompt' => $prompt,
                'max_tokens' => 50, // You can adjust this as needed
            ],
        ]);

        // Parse the API response
        $result = json_decode($response->getBody(), true);

        // Get the generated text from the response
        $generatedText = $result['choices'][0]['text'];

        // You can return the generated text as a JSON response
        return response()->json(['response' => $generatedText]);
    }
}
