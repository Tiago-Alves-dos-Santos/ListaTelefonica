{{--  bootstrap  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
{{-- plugins--}}
{{--https://mottie.github.io/tablesorter/docs/--}}
<script src="{{asset('plugins/js/tablesorter.min.js')}}"></script>
{{--https://www.jqueryscript.net/demo/Simple-Animated-jQuery-Dialog-Box-Plugin-msgbox--}}
<script src="{{asset('plugins/js/msgbox.js')}}"></script>
{{--Fim plugins--}}
{{--script global--}}
<script src="{{asset('js/global.js')}}"></script>
{{ $slot }}
