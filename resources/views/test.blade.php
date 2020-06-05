@extends('layouts.master')
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
@section('content')
<div id="app">
  @{{ message }}
</div>
@stop

@section('footer')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                message: 'Hello Vue!'
            }
        })
    </script>
@stop