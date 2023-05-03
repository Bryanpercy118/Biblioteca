<?php
use Laravel\Socialite\Facades\Socialite;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('login/appsconnected',function(){
    return Socialite::driver('appconnect')->redirect();

});
Route::get('login/appsconnected/callback', function(){

        $user = Socialite::driver('appconnect')->user();

        $token = $user->token;

        // intercambia el código de autorización por un token de acceso
        $response = Http::asForm()->post(config('services.appconnect.base_url') . '/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('services.appconnect.client_id'),
            'client_secret' => config('services.appconnect.client_secret'),
            'redirect_uri' => config('services.appconnect.redirect'),
            'code' => $request->input('code'),
        ]);

        $access_token = $response['access_token'];

        // autenticar al usuario en la aplicación Biblioteca
        Auth::guard('api')->setToken($access_token);

        return redirect('/home');

});

