<?php
namespace App\Services
;

use Illuminate\Support\Facades\Http;


class PhotoApiService
{

    public function all (){
        
        try{
            $url = env('URL_SERVER_API');
            $response = Http::retry(3,100)->get($url.'/photos');

            if ($response->getStatusCode() != 200) {
                throw new \Exception('Error en la respuesta de conexión a la API');
            }

            //return $response->json();
            return json_decode($response->getBody(), true);

            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        
        
    }

}