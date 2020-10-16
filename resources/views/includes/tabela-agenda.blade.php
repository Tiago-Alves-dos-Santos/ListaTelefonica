<div class="limiter">
    <div class="container-table100">
        <div class="wrap-table100">
            <div class="table100">
                <table id="tabela-agenda">
                    <thead>
                    <tr class="table100-head">
                        <th class="column1">Nome</th>
                        <th class="column2">Telefone</th>
                        <th class="column3">Operadora</th>
                        <th class="column4">Ação</th>
                    </tr>
                    </thead>
                    <tbody style="position: relative">
                    @component('components.load-tabela',['id'=>'tabela-agenda-load'])
                    @endcomponent
                    @forelse($agenda as $a)
                        @php
                            @endphp
                        <tr>
                            <td class="column1 linha-{{$a->id_telefone}}" data-nome="{{$a->nome}}">{{$a->nome}}</td>
                            <td class="column2 linha-{{$a->id_telefone}}" data-numero="{{$a->numero}}">{{$a->numero}}</td>
                            <td class="column3 linha-{{$a->id_telefone}}">{{$a->operadora}}</td>
                            <td class="column4 d-flex align-content-start">
                                <a href="" id="alterar-{{$a->id_telefone}}" class="btn btn-warning mt-2 mb-2 alterar" data-linha="{{$a->id_telefone}}">Alterar</a>
                                <a href="" class="btn btn-danger mt-2 ml-2 mb-2">Excluir</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="column1" style="text-align: center" colspan="4">Agenda Vazia</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="row" style="margin-top: 20px">
                <div class="col-md-6 d-flex justify-content-md-end justify-content-sm-center">
                    <h6>{{$registros}} / {{$agenda->total()}}</h6>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-center" id="pagina-agenda">
                    {{$agenda->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
{{--requisiçoes e plugins--}}
<script>
    $(function(){
        $("#tabela-agenda").tablesorter();
        //esconder load da tabela
        $("#tabela-agenda-load").hide();
        //paginação com ajax
        //colocar classe active no link clicado
        $('span.page-link').click(function () {
            $('.pagination').find('.active').removeClass('active');
            $(this).parent().addClass('active');
        });
        //ajax paginação
        $('.pagination .page-link').click(function (e) {
            e.preventDefault();
            $("#tabela-agenda-load").show('fast');
            let urls = $(this).attr('href');
            $.ajax({
                type: 'GET',
                url: urls,
                success: function (e) {
                    //mudar o container
                    $("#tabela-agenda").empty().html(e);

                },
                error: function (e) {

                }
            });
        });
        //alterar campos, colocar impute na linha clicada
        $("a.alterar").bind('click',function(e){
            e.preventDefault();
            let id_btn = $(this).attr('id');
            let linha = ".linha-"+$(this).attr('data-linha');
            let nome = $(linha).eq(0).html();
            let nome_antigo = $(linha).eq(0).attr('data-nome');
            let numero = $(linha).eq(1).html();
            let numero_antigo = $(linha).eq(1).attr('data-numero');
            let operadora = $(linha).eq(2).html();
            if($(this).html() == "Alterar"){
                $(linha).eq(0).html(
                    "<input type='text' value='"+nome+"' name='nome' class='form-control'/>"
                );
                $(linha).eq(1).html(
                    "<input type='text' value='"+numero+"' name='numero' class='form-control'/>"
                );
                $(linha).eq(2).html(
                    "<select class='custom-select'>" +
                    "<option value='TIM' >Tim</option>"+
                    "<option value='CLARO' >Claro</option>"+
                    "<option value='VIVO'>Vivo</option>"+
                    "<option value='OI'>Oi</option>"+
                    "</select>"
                );
                //lãço para selecionar a opçao ja escolhida
                for(let i = 0; i < $(linha+" select option").length; i++){
                    if(operadora == $(linha+" select option").eq(i).val()){
                        $(linha+" select option").eq(i).attr('selected','selected');
                    }
                }
                $(this).html("Salvar");
            }else if($(this).html() == "Salvar"){
                $(this).html('Aguarde <img src="{{asset('img/load-form.gif')}}" class="img-load-form img-fluid" />');
                let input_nome = $(linha+" input").eq(0).val();
                let input_numero = $(linha+" input").eq(1).val();
                let input_operadora = $(linha+" select").val();
                $(this).attr('disabled', true);
                $.ajax({
                    type:'POST',
                    url: "{{route('pessoa.ajax.update')}}",
                    data:{
                        "nome": input_nome,
                        "nome_antigo": nome_antigo,
                        "numero": input_numero,
                        "numero_antigo": numero_antigo,
                        "operadora": input_operadora,
                        "_token": "{{csrf_token()}}"
                    },
                    complete:function (e) {
                        $(this).removeAttr('disabled');
                        $(id_btn).empty().html("Salvar");
                    },
                    success:function (e) {
                        if($.isEmptyObject(e)){
                            $.ajax({
                                type: 'GET',
                                url: "{{$agenda->url($agenda->currentPage())}}",
                                success:function (tabela) {
                                    $("#tabela-agenda").empty().html(tabela);
                                    console.log(tabela);
                                    $.msgbox({
                                        'message': 'Alteração realizada com sucesso!',
                                        'type': 'info'
                                    });
                                }
                            });
                        }else{
                            let json = JSON.parse(e);
                            $.ajax({
                                type: 'GET',
                                url: "{{$agenda->url($agenda->currentPage())}}",
                                success:function (tabela) {
                                    $("#tabela-agenda").empty().html(tabela);
                                }
                            });
                            $.msgbox({
                                'message': json.msg,
                                'type': json.tipo
                            });
                        }

                    },
                    error:function (e) {
                        console.log(e.responseJSON.message);

                    }
                });
            }
        });

    });
</script>
