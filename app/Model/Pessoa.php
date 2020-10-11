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
    //pra inserção em massa
    protected $guarded = [];
    //fim config models
}
