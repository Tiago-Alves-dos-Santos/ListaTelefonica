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
}
