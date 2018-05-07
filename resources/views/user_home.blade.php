@extends('layouts.app')

@section('content')
@guest
@else
<div class="container-fluid">
    <div class="row">
        <div class="divv col-md-3" style="background-color: white; float: left;">
            @include('layouts.user')
        </div>

        <div class="divv col-md-9 backgrounduser py-4" id="isiform" style="float: right;">
            <div class="col-md-8 offset-md-2">
                    
            </div>
        </div>
    </div>
</div>
@endguest
@endsection