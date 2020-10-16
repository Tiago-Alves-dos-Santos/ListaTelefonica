<?php
namespace App\Classes;

class Configuracao
{
    const PAGINAS = 10;

    public static function mapPaginate($consultaPaginate){

        //caso pagina igual um reotrna apenas a quaintidade de instes da pagina
        if($consultaPaginate->currentPage() == 1){
            $registros = $consultaPaginate->count();
            return $registros;
        }
        //numero de intes mostrado por pagina (vezes x ) o numero da pagina atual
        $registros = $consultaPaginate->perPage() * $consultaPaginate->currentPage();
        //se itens mostrado por pagina for maior que o numero de intens da pagina atual
        if($consultaPaginate->perPage() > $consultaPaginate->count()){
            //faz o mesmo calculo acima, menos a diferença de (intes de mostrado pagina - qntd de intens da pagina)
            $registros = $consultaPaginate->perPage() * $consultaPaginate->currentPage() - ($consultaPaginate->perPage() - $consultaPaginate->count());
        }

        return $registros;
    }
}
