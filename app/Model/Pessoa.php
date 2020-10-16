<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
//classes diversas
class Pessoa extends Model
{
    //Config models
    use SoftDeletes;
    protected $table = 'pessoa';
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'criado';
    const UPDATED_AT = 'alterado';
    protected $guarded = [];

    public function telefone(){
        return $this->hasMany(Telefone::class);
    }
    //fim config models
    /**
     * @param $coluna
     * @param $valor
     * @param bool $retornarObjeto
     * @return mixed
     */
    public function vericarExistencia($coluna, $valor, $retornarObjeto = false){
        $existe = Pessoa::where($coluna,$valor)->exists();
        if($retornarObjeto && $existe){
            return Pessoa::where($coluna,$valor)->first();
        }else{
            return $existe;
        }
    }

    public function creates(){
        $pessoas =  Pessoa::create([
           "nome" => $this->nome
        ]);
        return $pessoas->fresh();
    }
}
