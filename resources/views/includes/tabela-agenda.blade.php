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
                    <tbody>
                    @forelse($agenda as $a)
                        @php
                            @endphp
                        <tr>
                            <td class="column1 linha-{{$a->id_telefone}}">{{$a->nome}}</td>
                            <td class="column2 linha-{{$a->id_telefone}}">{{$a->numero}}</td>
                            <td class="column3 linha-{{$a->id_telefone}}">{{$a->operadora}}</td>
                            <td class="column4 d-flex align-content-start">
                                <a href="" id="alterar" class="btn btn-warning mt-2 mb-2" data-linha="{{$a->id_telefone}}">Alterar</a>
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
        </div>
    </div>
</div>

<div class="row" style="margin-top: 20px">
    <div class="col-md-12 d-flex justify-content-md-end justify-content-center" id="pagina-agenda">
        {{$agenda->links()}}
    </div>
</div>
{{--requisiçoes e plugins--}}
<script>
    $(function(){
        $("#tabela-agenda").tablesorter();

        //paginação com ajax
        //colocar classe active no link clicado
        $('span.page-link').click(function () {
            $('.pagination').find('.active').removeClass('active');
            $(this).parent().addClass('active');
        });
        //ajax paginação
        $('.pagination .page-link').click(function (e) {
            e.preventDefault();
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
        $("a#alterar").bind('click',function(e){
            e.preventDefault();
            let linha = ".linha-"+$(this).attr('data-linha');
            let nome = $(linha).eq(0).html();
            let numero = $(linha).eq(1).html();
            let operadora = $(linha).eq(2).html();
            if($(this).html() == "Alterar"){
                $(linha).eq(0).html(
                    "<input type='text' value='"+nome+"' name='nome' class='form-control'/>"
                );
                $(linha).eq(1).html(
                    "<input type='text' value='"+numero+"' name='numero' class='form-control'/>"
                );
                $(linha).eq(2).html(
                    "<input type='text' value='"+operadora+"' name='numero' class='form-control'/>"
                );
                $(this).html("Salvar");
            }else if($(this).html() == "Salvar"){
                alert("ola salvar");
            }
        });

    });
</script>
