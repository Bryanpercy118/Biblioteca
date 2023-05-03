<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;
class AppsConnectController extends Controller
{
    //
    public function index()
{
    $client = new \GuzzleHttp\Client();
    $response = $client->post('http://127.0.0.1:8000/api/v1/create-client', [
        'form_params' => [
            'grant_type' => 'client_credentials',
            'client_id' => env('APPS_CONNECT_CLIENT_ID'),
            'client_secret' => env('APPS_CONNECT_CLIENT_SECRET')
        ]
    ]);
    $token = json_decode((string) $response->getBody(), true)['access_token'];
    // Almacenar el token en caché o en la base de datos si lo deseas
}

public function getUserData()
{
    // Obtener el token de acceso almacenado en caché o en la base de datos si lo deseas
    $token = 'tu-token-de-acceso';

    $client = new \GuzzleHttp\Client();
    $response = $client->get('http://127.0.0.1:8000/api/v1/user', [
        'headers' => [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ]
    ]);
    $userData = json_decode((string) $response->getBody(), true);
    return response()->json($userData);
}

}
