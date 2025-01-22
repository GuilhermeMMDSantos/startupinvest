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

Route::get('/javascript-disabled', function () {
    return view('javascript-disabled');
})->name('javascript.disabled');


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

Route::get('mensagens','MessageController@index')->name('mensagens.menu')->middleware('auth');

Route::post('mensagens','MessageController@index')->name('mensagens_post')->middleware('auth');

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

Route::get('/eliminar_membro_startup','UserController@eliminarMembroStartup');

Route::post('/criar_oferta','RodadasController@cadastrarOferta');

Route::get('/anular_oferta','RodadasController@anularOferta');


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

Route::get('/show_menu_mobile','UserController@showMenuMobile')->name('menu_mobile');

Route::get('/load_paypal_form','PagamentosController@loadFormInvestirPaypal');

Route::get('/set_payment','PagamentosController@investirComPaypal'); // feature inacabada 

Route::get('/get_startups_no_portifolio','UserController@getStartupsNoPortifolio');

Route::get('/rodadas','UserController@showRodadasPage')->name('rodadas.page')->middleware('auth'); // feature inacabada

Route::get('/rodadas_admin','AdminController@showRodadasPage')->name('rodadas.page.admin')->middleware('auth');

Route::get('/rodada_page_admin/2024{id_rodada}','AdminController@showRodadaPage')->name('rodada.page.admin')->middleware('auth');

Route::get('/load_estatistica_rodadas','UserController@loadEstatisticaRodadas');

Route::get('/load_lista_rodadas/{page?}','UserController@loadListaRodadas')->middleware('auth');

Route::get('/rodada_page/2024{id_rodada}','RodadasController@showPage')->name('rodada.page')->middleware('auth');

Route::get('/load_intro_rodada', 'RodadasController@load_intro_rodada');

Route::get('/TESTE','PagamentosController@teste');

Route::get('/atualizar_porcentagem_pelo_montante','PagamentosController@atualizarPorcentagemPeloMontante');


Route::get('/view_to_assign_pdf','RodadasController@visualizarParaAssinarPdf')->name('view_pdf');


Route::post('/add-signature','RodadasController@addSignature')->name('pdf.add-signature');



Route::get('/sign_contract','RodadasController@signContract')->middleware('auth');


Route::post('/save_contrato','RodadasController@saveContrato');

Route::get('/rm_contrato','RodadasController@removeContrato');

Route::get('/update_iinvest_situation1','RodadasController@updateIinvestSituation1');

Route::get('/update_iinvest_situation2','RodadasController@updateIinvestSituation2');

Route::get('/view_doc/{rodada}{other}','RodadasController@viewDoc')->name('view_doc');

Route::get('/confirmar_assinatura','RodadasController@confirmarAssinatura');

Route::post('/discordar_contrato','RodadasController@discordarContrato');

Route::get('/payouts','PagamentosController@sendPayout')->middleware('auth.ajax');

Route::get('/payteste', 'PagamentosController@showTestePage')->name('payteste');

Route::post('/createP', 'PagamentosController@sendAmountForInvest')->name('paypal.pay');

Route::get('/captureP', 'PagamentosController@getAprovalInvest')->name('paypal.status');

Route::get('/get_avaluation', 'userController@getAvaluation')->middleware('auth.ajax');

Route::get('/set_reference_payment', 'PagamentosController@setRefPayment' )->middleware('auth.ajax');