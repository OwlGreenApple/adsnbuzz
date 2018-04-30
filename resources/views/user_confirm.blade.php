@extends('layouts.app')

@section('content')
<div class="container" id="isiform">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Confirm Payment</div>

                <div class="card-body">
                	<form action="{{url('/report/save')}}" method="post" enctype="multipart/form-data">
	                    <table class="table table-bordered">
	                    	<thead>
	                    		<th>Tanggal Order</th>
	                    		<th>Jumlah Order</th>
	                    		<th>Kode Kupon</th>
	                    		<th>Opsi Bayar</th>
	                    		<th>Bukti Bayar</th>
	                    		<th>Status</th>
	                    	</thead>
	                    	<tbody>
	                    		@foreach ($orders as $order)
	                    			<tr>
	                    				<td>{{ $order->tgl_order }}</td>
	                    				<td>{{ $order->jml_order }}</td>
	                    				<td>{{ $order->kodekupon }}</td>
	                    				<td>{{ $order->opsibayar }}</td>
	                    				<td><input id="buktibayar" name="buktibayar" type="file"/></td>
	                    				@if ($order->konfirmasi==0)
	                    					<td style="color:red;">Belum di konfirmasi</td>
	                    				@else
	                    					<td style="color:green;">Sudah di konfirmasi</td>
	                    				@endif
	                    			</tr>
	                    		@endforeach
	                    	</tbody>
	                    </table>
                    </form>
                </div>       
            </div>
        </div>
    </div>
</div>

<div class = "container"> 
	 <div class="row justify-content-center">
	 	<span align="center" id="pesan"></span>
	 </div>
</div>
@endsection
