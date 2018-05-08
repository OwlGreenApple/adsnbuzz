@extends('layouts.app')

@section('content')
@guest
@else
<div class="container-fluid">
    <div class="row">
        <div class="daftarmenu col-md-3">
            @include('layouts.user')
        </div>

        <div class="kontenmenu col-md-9 py-4" id="isiform">
            <div class="col-md-8 offset-md-2">
            	<img src="{{ asset('design/balon2.png') }}" class="balondashboard">
            	<h1 class="hellouser">
            		Hello, {{ $user->name }}</h1>   
            </div>
        </div>
    </div>
</div>
@endguest
@endsection