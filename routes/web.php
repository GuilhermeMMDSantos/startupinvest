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

Route::get('paineladmin', 'AdminController@index')->name('admin.stackholders');


Route::post('atualizar_stado', 'AdminController@atualizarEstadoUser');

//Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@index')->name('home');
Route::get('buscar_incubadora_aceleradora', 'HomeController@buscarIncubadoraAceleradora');

Route::post('empreendedor/cadastrar', 'AuthController@cadastrarStartup')->name("cadastro.startup");
Route::post('investidor/cadastrar', 'AuthController@cadastrarInvestidor')->name("cadastro.investidor");

Route::get('processamento_cadastro', 'HomeController@loadWaitValidationPag')->name("processamento.cadastro");

Route::post('loginuser', 'AuthController@loginuser')->name('user.login');



Route::get('userout', 'AuthController@logoutUser');

Route::get('stackholder_startup', 'HomeController@loadHomePag')->name('startup.menu')->middleware('auth');;

Route::get('stackholder_investidor', 'HomeController@loadInvestidoresPage')->name('investidor.menu')->middleware('auth');

Route::get('notificacoes', 'NotificationController@loadNotifications')->name('notificacao.menu')->middleware('auth');

Route::get('mensagens','MessageController@index')->name('mensagens.menu')->middleware('auth');;

Route::get('/shownotification/{notificationId}','NotificationController@showOwnerNotification')->name('showownernotification')->middleware('auth');;

Route::group(['prefix' => '/startup', 'middleware' => 'auth'], function () {
    Route::get('/load', 'UserController@loadStartups');
    Route::get('/filter', 'UserController@filtrarStartups');
});

Route::get('/profile/{codeUser}', 'UserController@showPerfil')->name('startup.perfil')->middleware('auth');

Route::get('/load_oferta','UserController@loadOferta');

Route::get('load_form_editar_introducao_startup','UserController@loadFormEditIntroStartup');

Route::post('load_tmp_img','UserController@loadTmpImg');

Route::post('edit_intro_startup','UserController@editarIntroStartup');

Route::get('/resetar_logotipo','UserController@resetarLogotipo');

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

Route::post('load_tmp_img_membro_equipa','UserController@loadTmpImgMembroEquipa');

Route::post('/add_membro_equipa','UserController@adicionarMembroEquipa');

Route::post('/criar_oferta','UserController@cadastrarOferta');

Route::get('/anular_oferta','UserController@anularOferta');


Route::get('/get_experiencia_investidor','UserController@getExperienciasDoInvestidor');

Route::post('/cadastrar_experiencia_investidor','UserController@cadastrarExperienciasDoInvestidor');

Route::get('/get_formacao_investidor','UserController@getFormacoesDoInvestidor');

Route::get('/get_introducao_investidor','UserController@getIntroducaoInvestidor');

Route::post('/cadastrar_formacao_investidor','UserController@cadastrarFormacaoInvestidor');

Route::get('/solicitar_pitch','UserController@solicitarPitch');

Route::get('/set_permissao_ver_pitch','UserController@setPermissaoVerPitch');

Route::get('/get_conversas','ChatController@getConversas');

Route::get('/send_message','ChatController@sendMessage');

Route::get('/get_messages','ChatController@getMessages');

Route::get('/get_info_destinatario','ChatController@getInfoDestinatario');

Route::get('/verificar_permissao_para_enviar_mensagem','ChatController@verificarPermissaoParaEnviarMensagem');

Route::get('/load_membros_equipa','UserController@loadMembrosEquipa');

Route::get('/delete_membros_equipa','UserController@deleteMembrosEquipa');

Route::get('/get_startups_investidas','UserController@getStartupsInvestidas');

Route::get('/gerar_referencia_pagamento','PagamentosController@createReference');
Route::get('/get_pagamentos','PagamentosController@getPagamentos')->middleware('auth');
Route::get('/show_pagamento_page','PagamentosController@index')->name('admin.pagamento.page')->middleware('auth');
Route::get('/confirmar_pagamento','PagamentosController@confirmPayment')->middleware('auth');

Route::get('/','HomeController@showNewHome')->name('new_home_page');

Route::get('/new_cadastro_page','HomeController@showNewCadastroPage')->name('new_cadastro_page');
Route::get('/new_login_page','HomeController@showNewLoginPage')->name('new_login_page');


Route::get('/load_popup_chat','UserController@loadPopUpChat');

Route::post('/send_message','UserController@sendMessage');

Route::get('/get_new_message','UserController@getNewMessage');


Route::get('/load_meetings','MessageController@loadMeetings');

Route::get('/load_messages_meeting','MessageController@loadMessageMeeting');

Route::post('/send_message_page','MessageController@sendMessage');

Route::get('/set_status_message','MessageController@setMessageStatus');

Route::get('/show_meeting_empty','MessageController@showMeetingEmpty');