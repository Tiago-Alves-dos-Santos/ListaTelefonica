<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @if($titulo == "")
    <title>Lista Telefonica</title>
    @else
    <title>{{ $titulo }}</title>
    @endif
    {{--  Boostrap importado  --}}
    <link rel="stylesheet" type="text/css" href="{{ mix('css/lista-telefonica.css') }}"/>
    {{--  jquery  --}}
    <script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
    {{ $slot }}
</head>
