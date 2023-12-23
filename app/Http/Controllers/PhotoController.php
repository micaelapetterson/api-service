<?php

namespace App\Http\Controllers;

Use App\Services\PhotoApiService;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

use App\Models\Photo;


class PhotoController extends Controller
{

    protected $photoApiService;

    public function __construct(photoApiService $photoApiService){
        $this->photoApiService = $photoApiService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $responses = $this->photoApiService->all();

        $this->clearTable();

        foreach ($responses as $key => $response) {

            $this->store($response);
        }

        return response()->json(['message' => 'Sincronización exitosa']);

    }


    public function store ($request){

        $validator = Validator::make($request, [
            'id' => 'required|numeric',
            'url' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Error en la validación de los datos: ' . $validator->errors()->first());
        }

        $photo = New Photo();

        $photo->id = $request['id'];
        $photo->albumId = $request['albumId'];
        $photo->title = $request['title'];
        $photo->url = $request['url']; 
        $photo->thumbnailUrl = $request['thumbnailUrl']; 

        $photo->save();      

    }

    
    public function clearTable()
    {
        Photo::truncate();
    }

}
