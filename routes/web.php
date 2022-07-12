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
Route::get('buscar_incubadora_aceleradora', 'HomeController@buscarIncubadoraAceleradora');

Route::post('empreendedor/cadastrar', 'AuthController@cadastrarStartup')->name("cadastro.startup");
Route::post('investidor/cadastrar', 'AuthController@cadastrarInvestidor')->name("cadastro.investidor");

Route::get('processamento_cadastro', 'HomeController@loadWaitValidationPag')->name("processamento.cadastro");

Route::post('loginuser', 'AuthController@loginuser')->name('user.login');



Route::get('userout', 'AuthController@logoutUser');

Route::get('stackholder_startup', 'HomeController@loadHomePag')->name('startup.menu');
Route::get('stackholder_investidor', 'HomeController@loadInvestidoresPage')->name('investidor.menu');

Route::group(['prefix' => '/startup', 'middleware' => 'auth'], function () {
    Route::get('/load', 'UserController@loadStartups');
    Route::get('/filter', 'UserController@filtrarStartups');
});

Route::get('/profile/{codeUser}', 'UserController@showPerfil')->name('startup.perfil')->middleware('auth');

Route::get('/load_oferta','UserController@loadOferta');

Route::get('load_form_editar_introducao_startup','UserController@loadFormEditIntroStartup');

Route::post('load_tmp_img','UserController@loadTmpImg');

Route::post('edit_intro_startup','UserController@editarIntroStartup');




Route::get('/load_introducao_startup','UserController@loadIntroducaoStartup');

Route::get('load_investors_table/{page?}','UserController@loadInvestorsTable');





Route::get('adicionar_investidor','UserController@adicionarInvestidor');

Route::get('load_form_editar_investidor_startup','UserController@loadFormEditarInvestidorStartup');

Route::get('editar_investidor_startup','UserController@editarInvestidorStartup');


Route::get('eliminar_investidor_startup','UserController@eliminarInvestidorStartup');

Route::get('buscar_certificados','UserController@buscarCertificados');

Route::get('buscar_areas_formacao','UserController@buscarAreasFormacao');

Route::get('buscar_cargos_executvo','UserController@buscarCargosExecutvo');

Route::get('buscar_funcao_experiencia','UserController@buscarFuncaoExperiencia');

Route::get('buscar_intituicao_experiencia','UserController@buscarIntituicaoExperiencia');

Route::get('/email','AuthController@sendMail');


Route::post('load_tmp_img_membro_equipa','UserController@loadTmpImgMembroEquipa');

Route::post('/add_membro_equipa','UserController@adicionarMembroEquipa');

Route::post('/criar_oferta','UserController@cadastrarOferta');

Route::get('/anular_oferta','UserController@anularOferta');


Route::get('/get_experiencia_investidor','UserController@getExperienciasDoInvestidor');

Route::post('/cadastrar_experiencia_investidor','UserController@cadastrarExperienciasDoInvestidor');

Route::get('/get_formacao_investidor','UserController@getFormacoesDoInvestidor');

Route::post('/cadastrar_formacao_investidor','UserController@cadastrarFormacaoInvestidor');