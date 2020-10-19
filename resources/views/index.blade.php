<!DOCTYPE html>
<html lang="en">
@component('components.cabecalho', ['titulo' => ''])
@endcomponent
<body>
@include('includes.load')
<div class="container">
    {{--    Titulo do site--}}
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
            <h1> Lista Telefonica </h1>
        </div>
    </div>
    {{--Botoes de opção--}}
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
            <a href="" class="btn btn-outline-azverde" id="opcao-adicionar">Adicionar</a>
            <a href="" class="btn btn-outline-azverde" id="opcao-filtrar">Buscar</a>
        </div>
    </div>
    {{--        formulario adicionar--}}
    <div class="row" style="margin-top: 50px" id="adicionar">
        <div class="col-md-12">
            @component('components.fieldset', ['titulo' => 'Adicionar'])
                <form method="post" action="{{route('pessoa.create.contato')}}" id="form-adicionar">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-4">
                            <label>Nome do contato:</label>
                            <input id="nome-contato" name="nome" type="text" class="form-control"
                                   placeholder="Anonimo Nome" required/>
                        </div>
                        <div class="col-md-3">
                            <label>Nº do contato(DDD Opcional): </label>
                            <input name="numero" type="text" class="form-control" placeholder="(88) 999240996"
                                   required/>
                            <small id="emailHelp" class="form-text text-muted">O DDD previne a duplicidade em
                                numeros!</small>
                        </div>
                        <div class="col-md-3">
                            <label>Operadora pertencente ao numero:</label>
                            <select class="custom-select" name="operadora" required>
                                <option value="">Selecione a operadora!</option>
                                <option value="TIM">Tim</option>
                                <option value="CLARO">Claro</option>
                                <option value="VIVO">Vivo</option>
                                <option value="OI">Oi</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-content-center flex-wrap mt-2 ">
                            {{--                                <i class="fas fa-check"></i>--}}
                            <button type="submit" class="btn btn-block btn-azul" id="btn-add-contato"><span
                                    id="texto-btn-add">Salvar</span> <img src="{{asset('img/load-form.gif')}}"
                                     class="img-load-form img-fluid" id="img-add"/></button>
                        </div>
                    </div>
                </form>
            @endcomponent
        </div>
    </div>

    <!--<editor-fold desc="Formulario de busca-filtro">-->
    <div class="row" style="margin-top: 50px" id="buscar">
        <div class="col-md-12">
            @component('components.fieldset', ['titulo' => 'Buscar'])
                <form method="post" action="{{route('pessoa.ajax.filtro')}}" id="form-busca">
                    @csrf
                    <div class="form-row">
{{--                        <div class="col-md-8">--}}
{{--                            <label>Procure por um contato </label>--}}
{{--                            <input name="busca" type="text" class="form-control" placeholder="Buscar... " required/>--}}
{{--                        </div>--}}

                        <div class="col-md-12">
                            <label>Procure por um contato </label>
                            <div class="input-group">
                                <input name="busca" type="text" class="form-control" placeholder="Buscar... " required/>
                                <div class="input-group-append">
                                    <button style="width: 150px" type="submit" class="btn btn-block btn-azul"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>

{{--                        <div class="col-md-4 d-flex align-content-end flex-wrap mt-2">--}}
{{--                            <button type="submit" class="btn btn-block btn-azul"><i class="fas fa-search"></i></button>--}}
{{--                        </div>--}}
                    </div>
                </form>
            @endcomponent
        </div>
    </div>
    <!--</editor-fold>-->
    <!--<editor-fold desc="Tabele include, tabela de contatos">-->
    <div class="row" style="margin-top: 0">
        <div class="col-md-12" id="tabela-agenda">
            @include('includes.tabela-agenda')
        </div>
    </div>
    <!--</editor-fold>-->

</div>

@component('components.scripts')
    <script src="{{asset('js/index.js')}}"></script>
    <script>
        //form adicionar | adicionar na agenda
        $("form#form-adicionar").bind('submit', function (e) {
            e.preventDefault();
            let texto = $("#texto-btn-add").html();
            $("#btn-add-contato").attr('disabled', true);
            $("#texto-btn-add").html("Aguarde");
            $("#img-add").show();
            let dados = $(this).serialize();
            let pagina_atual = $("#pagina-agenda").find('.pagination').find('.active').find('span').html();
            <!--Cadastrar novo contato na agenda-->
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: dados,
                complete: function (e) {
                    $("#img-add").hide();
                    $("#texto-btn-add").html(texto);
                    $("#btn-add-contato").removeAttr('disabled');
                },
                success: function (e) {
                    let json = JSON.parse(e);
                    $.msgbox({
                        'message': json.msg,
                        'type': json.tipo
                    });
                    @php
                        session()->forget('msg');
                    @endphp
                    <!--requisiçaõ de consulta apos um cadastro de usuario-->
                    $.ajax({
                        type: 'GET',
                        url: "{{route('inicio')}}" + "?page=" + pagina_atual,
                        success: function (e) {
                            //mudar o container
                            $("#tabela-agenda").empty().html(e);

                        },
                        error: function (e) {

                        }
                    });
                    <!--fim requisiçaõ de consulta apos um cadastro de usuario-->
                },
                error: function (e) {

                }
            });
            <!--fim Cadastrar novo contato na agenda-->
        });

        let dados = null;
        $("#nome-contato").autocomplete({
            source: function (request, response) {
                $.ajax({
                    type: 'GET',
                    url: "{{route('pessoa.ajax.datalist')}}",
                    data: {
                        "nome": $("#nome-contato").val()
                    },
                    success: function (e) {
                        let json = [];
                        for (let i = 0; i < e.length; i++) {
                            let item = {};
                            item["value"] = e[i].nome;
                            item["label"] = e[i].nome;
                            item["img"] = "https://source.unsplash.com/random/10x10";
                            json.push(item);
                        }
                        dados = json;
                        response(dados);
                    }
                })
            },
            minLength: 1,
            html: true,
            open: function (event, ui) {
                $(".ui-autocomplete").css("z-index", 1000);
            }
        }).autocomplete("instance")._renderItem = function (ul, item) {
            let expressao = new RegExp(this.term, 'gi');
            let palavra = item.label.replace(expressao, "<span style='font-weight:bolder; color:rgba(36, 103, 145, 1)'>" + this.term + "</span>");
            return $("<li><div><span>" + palavra + "</span></div></li>").appendTo(ul);
        };

        //requisição buscar
        $("form#form-busca").bind('submit',function (e) {
            e.preventDefault();
            let dados = $(this).serialize();
            $("#tabela-agenda-load").show('fast');
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: dados,
                success:function(e){
                    $("#tabela-agenda").empty().html(e);
                },
                error:function (e) {
                    console.log(e);
                }
            });
        });
    </script>
@endcomponent
{{--destroi sessao de msg--}}

</body>
</html>
