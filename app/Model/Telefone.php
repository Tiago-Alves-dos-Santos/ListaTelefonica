<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
class Telefone extends Model
{
    //Config models
    use SoftDeletes;
    protected $table = 'telefone';
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'criado';
    const UPDATED_AT = 'alterado';
    protected $guarded = [];

    public function pessoa(){
        return $this->belongsTo(Pessoa::class);
    }
    //fim config models

    public function vericarExistencia($coluna, $valor, $retornarObjeto = false){
        $existe = Telefone::where($coluna,$valor)->exists();
        if($retornarObjeto && $existe){
            return Telefone::where($coluna,$valor)->first();
        }else{
            return $existe;
        }
    }

    public function creates(){
        Telefone::create([
            "numero" => $this->numero,
            "operadora" => $this->operadora,
            "pessoa_id" => $this->pessoa_id
        ]);
    }
}
