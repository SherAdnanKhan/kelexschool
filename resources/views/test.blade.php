@extends('layouts.master')

@section('content')
    <p id="power">0</p>
@stop

@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
    <script>
        //var socket = io('http://localhost:3000');
        var socket = io('http://localhost:3000/test');
        // socket.on("test-channel:App\\Events\\EventName", function(message){
        //     console.log(message);
        //     // increase the power everytime we load test route
        //     //$('#power').text(parseInt($('#power').text()) + parseInt(message.data.power));
        // });
    </script>
@stop