<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailSenha;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('paineladmin', 'AdminController@index');


Route::post('atualizar_stado', 'AdminController@atualizarEstadoUser');

Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@index')->name('home');

Route::post('empreendedor/cadastrar', 'AuthController@cadastrarStartup')->name("cadastro.startup");
Route::post('investidor/cadastrar', 'AuthController@cadastrarInvestidor')->name("cadastro.investidor");

Route::get('processamentocadastro', 'HomeController@loadWaitValidationPag')->name("processamento.cadastro");

Route::post('loginuser', 'AuthController@loginuser')->name('user.login');



Route::get('userout', 'AuthController@logoutUser');

Route::get('ecostartup', 'HomeController@loadHomePag');

Route::group(['prefix' => '/startup', 'middleware' => 'auth'], function () {
    Route::get('/load', 'StartupController@loadStartups');
    Route::get('/filter', 'StartupController@filtrarStartups');
});

Route::get('/user_perfil', 'UserController@showPerfil')->name('user.perfil');
Route::get('/user_perfil_/{item}', 'UserController@showPerfilOther')->name('user_perfil');

Route::get('/email', function () {
    Mail::to('guiframart1@gmail.com')->send(new EmailSenha());
    echo "Email enviado";
});
