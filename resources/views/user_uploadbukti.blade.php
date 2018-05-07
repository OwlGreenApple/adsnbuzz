@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="divv col-md-3" style="background-color: white; float: left;">
            @include('layouts.user')
        </div>

        <div class="divv col-md-9 backgrounduser py-4" id="isiform" style="float: right;">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                	<div class="card-header">Upload Bukti Bayar</div>

	                <div class="card-body">
	                	<form action="{{url('/confirm-user/save/'.$order->id)}}" method="post" enctype="multipart/form-data">
	                		@csrf
		                    <div class="form-group">
		                    	<h3><strong>Informasi Order</strong></h3>
		                    	<p>Tanggal Order 	= {{$order->tgl_order}}</p>
		                    	<p>Jumlah Order		= Rp. <?php echo number_format("$order->jml_order") ?></p>
		                    	<p>Kode Kupon		= {{$order->kodekupon}}</p>
		                    	<p>Opsi Bayar 		= {{$order->opsibayar}}</p>
		                    </div>
		                   	<div class="form-group">
		                   		<input id="buktibayar" name="buktibayar" type="file"/>	
		                   	</div>
		                   	<div class="form-group" align="center">
		                   		<button type="submit" class="btn btn-primary"> Upload </button>
		                   	</div>
	                    </form>

	                    @if(session()->has('message'))
	                		@if(session()->get('message')=='File berhasil diupload')
							    <div class="alert alert-success">
							        {{ session()->get('message') }}
							    </div>
							@else
								<div class="alert alert-warning">
							        {{ session()->get('message') }}
							    </div>
							@endif
						@endif
	                </div>           
                </div>    
            </div>
        </div>  
    </div>  
</div>
@endsection
