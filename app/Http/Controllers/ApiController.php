<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\StreamedResponse;
use GuzzleHttp\Client;
use Guzzle\Stream\PhpStreamRequestFactory;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\StreamInterface;

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
        $input = "Wanneer begint de winter?";
        $OPENAI_API_KEY = env('OPENAI_API_KEY');
        
       
        $client = new Client([
            'base_uri' => 'https://api.openai.com/v1/', 
            'stream' => true
        ]);

        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ], 
            'json' => [
                'model' => "gpt-3.5-turbo",
                'messages' => [["role" => "user", "content" => $prompt]],
                'stream' => true,
                'temperature' => 0 
            ], 
        ]);
        
                
        $body = $response->getBody();
        while (!$body->eof()) {
            echo $body->read(1024);
        }
    }
}
