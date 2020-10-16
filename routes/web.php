<?php

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

Route::get('/', 'Controller\PessoaC@homepage')->name('inicio');
Route::prefix("/contato")->group(function(){
    //salvar um novo conto ou adioconar um numero a um existente
    Route::post('/novo-contato', 'Controller\PessoaC@salvarContato')->name('pessoa.create.contato');
    //requisiçao para preencher o autocomplete
    Route::get('/datalist-dados', 'Controller\PessoaC@dataListRequest')->name('pessoa.ajax.datalist');
    //alterar um contato
    Route::post('/editar-contato','Controller\PessoaC@alterarContato')->name('pessoa.ajax.update');
    //deletar um contato
    Route::post('/deletar', 'Controller\PessoaC@deletar')->name('pessoa.ajax.delete');
});

//Route::prefix("/app")->group(function(){
//    //pagina inicial do barra app
//    Route::get('/', function () {
//        return 'Inicio app';
//    });
//    //é como se fosse app/user
//    Route::get('/user', function () {
//        return 'User dentro de app';
//    });
//    //é como se fosse app/profile
//    Route::get('/profile', function () {
//        return 'User dentro de profile';
//    });
//});
