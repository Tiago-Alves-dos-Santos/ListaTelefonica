<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{--  icone da aplicação  --}}
    <link rel="icon" href="{{asset('img/30x30.png')}}"/>
    @if($titulo == "")
        <title>Lista Telefonica</title>
    @else
        <title>{{ $titulo }}</title>
    @endif
    {{--    normaliza css--}}
    <link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css"/>
    {{--  Boostrap importado  --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}"/>
    {{--    animate css--}}
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    {{--    jquery ui css--}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" rel="stylesheet"/>
    {{--  css da pagina  --}}
    <link rel="stylesheet" type="text/css" href="{{ mix('css/lista-telefonica.css') }}"/>
    {{--  font awessome  --}}
    <script src="https://kit.fontawesome.com/100dc002c3.js" crossorigin="anonymous"></script>
    {{--  jquery  --}}
    <script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
    {{--    jquery ui js--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    {{ $slot }}
</head>
