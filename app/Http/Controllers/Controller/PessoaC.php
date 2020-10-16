<?php

namespace App\Http\Controllers\Controller;

use App\Classes\Configuracao;
use App\Model\Pessoa;
use App\Model\Telefone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PessoaC extends Controller
{

    public function homepage(Request $req){
        //carrega tabela padrao ajax
        $agenda = Pessoa::join('telefone','pessoa.id','=','telefone.pessoa_id')
            ->select('*', 'telefone.id as id_telefone')
            ->orderBy('pessoa.nome')->paginate(Configuracao::PAGINAS);
        $registros = Configuracao::mapPaginate($agenda);
        if($req->ajax()){
            return view('includes.tabela-agenda', compact('agenda','registros'));
        }
        //carregar pessoas no datalist sem ser por requisição
        $pessoas = Pessoa::groupBy('nome')->orderBy('nome')->limit(10)->get();
        //carregar tabelas de contatos salvos
       return view('index', compact('pessoas','agenda','registros'));
    }

    public function salvarContato(Request $req){
        //verficar se pessoa existe
        $pessoas = new Pessoa();
        $pessoa = $pessoas->vericarExistencia('nome',$req->nome, true);
        //verficar se telefone existe
        $telefones = new Telefone();
        $telefone = $telefones->vericarExistencia('numero',$req->numero);
        if($telefone){
            session(['msg' => [
                'tipo' => 'info',
                'msg' => 'Telefone ja existente impossivel cadastrar!'
            ]]);
        }else if($pessoa != false && !$telefone){//se pessoa existir e telefone nao, adicionar telefone a pessoa
            $telefones->numero = $req->numero;
            $telefones->operadora = $req->operadora;
            $telefones->pessoa_id = $pessoa->id;
            $telefones->creates();
            session(['msg' => [
                'tipo' => 'info',
                'msg' => 'Numero '.$telefones->numero.' adicionado ao contato '.$pessoa->nome.' com sucesso! '
            ]]);
        }else if($pessoa == false && !$telefone){//se pessoa nao existir nem o telefone cadastres ambos
            $pessoas->nome = $req->nome;
            $pessoas = $pessoas->creates();
            $telefones->numero = $req->numero;
            $telefones->operadora = $req->operadora;
            $telefones->pessoa_id = $pessoas->id;
            $telefones->creates();
            session(['msg' => [
                'tipo' => 'info',
                'msg' => 'Novo contato '.$pessoas->nome.' - '.$telefones->numero.' criado com sucesso! '
            ]]);

        }
        return json_encode(session('msg'));

    }

    public function dataListRequest(Request $req){
        //requisiçaõ para datalist de nomes para adionar na agenda
        if($req->ajax()){
            return Pessoa::where('nome','like', "%".$req->nome."%")
                ->orderBy('nome')->limit(15)->get();
        }
    }

    public function alterarContato(Request $req){
        if($req->ajax()){
            $telefone = Telefone::where('numero', $req->numero_antigo)->first();
            $telefone->numero = $req->numero;
            $telefone->operadora = $req->operadora;
            $telefone->pessoa->nome = $req->nome;
            $telefone->save();
            $telefone->pessoa->save();
            return [];
        }
    }
}
