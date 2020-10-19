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
    //filtrar agenda
    Route::match(['get', 'post'], '/filtrar', 'Controller\PessoaC@buscar')->name('pessoa.ajax.filtro');
});

