<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        
        // $client = new Client();

        // Make a POST request to the OpenAI API
        $response = Http::timeout(60)
            ->withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions',[
                'model' => "gpt-3.5-turbo",
                // 'model' => "text-davinci-003",
                'messages' => [["role" => "user", "content" => $prompt]]
        ]);

        // Parse the API response
        $result = json_decode($response->getBody(), true);
        $summary = $result['choices'][0]['message']['content'];
 
        return view('dashboard/summary/summary')->with('summary', $summary);
    }
}
