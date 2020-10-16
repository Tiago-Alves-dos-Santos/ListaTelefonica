$(function(){
    //esconder div adicionar e filtro
    $("#adicionar").hide();
    $("#buscar").hide();

    //mostrar buscar ao clicar na opção busca
    let opcao ={
        adicionar: "a#opcao-adicionar",
        buscar: "a#opcao-filtrar"
    };
    //mostrar adicionar ao clicar
    $(opcao.adicionar).bind('click', function(e){
        e.preventDefault();
        $(this).toggleClass('opcao-selecionada');
        $(opcao.buscar).removeClass('opcao-selecionada');
        $("#buscar").fadeOut('slow');
        setTimeout(function () {
            $("#adicionar").fadeToggle('slow');
        },600);
    });
    //mostrar buscar ao clicar
    $(opcao.buscar).bind('click', function(e){
        $("#adicionar").fadeOut('slow');
        e.preventDefault();
        $(this).toggleClass('opcao-selecionada');
        $(opcao.adicionar).removeClass('opcao-selecionada');
        setTimeout(function () {
            $("#buscar").fadeToggle('slow');
        },600);

    });
    // $.msgbox({
    //     'message' : 'Olá, deu certo',
    //     'type' : 'info'
    // });
});
