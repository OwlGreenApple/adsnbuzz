@extends('layouts.app')

@section('content')
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Dashboard Admin</div>

        <div class="card-body">
          @if (session('status'))
            <div class="alert alert-success">
              {{ session('status') }}
            </div>
          @endif

          Hai, <b>{{ Auth::user()->name }}</b>!<br>
          Anda login sebagai Admin!
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
