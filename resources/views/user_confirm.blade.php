@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="divv col-md-3" style="background-color: white; float: left;">
	        @include('layouts.user')
	    </div>

	    <div class="divv col-md-9 backgrounduser py-4" id="isiform" style="float: right;">
	        <div class="card">
	       		<div class="card-header">Confirm Payment</div>

                <div class="card-body">
	                    <table class="table table-bordered">
	                    	<thead align="center">
	                    		<th>Tanggal Order</th>
	                    		<th>Nomor Order</th>
	                    		<th>Jumlah Order</th>
	                    		<th>Kode Kupon</th>
	                    		<th>Opsi Bayar</th>
	                    		<th colspan="2">Bukti Bayar</th>
	                    		<th>Status</th>
	                    	</thead>
	                    	<tbody>
	                    		@foreach ($orders as $order)
	                    			<tr>
	                    				<td>{{ $order->tgl_order }}</td>
	                    				<td>{{ $order->no_order }}</td>
	                    				<td>Rp. <?php echo number_format("$order->jml_order") ?></td>
	                    				<td>{{ $order->kodekupon }}</td>
	                    				<td>{{ $order->opsibayar }}</td>
	                    				<td align="center"><form action="{{url('/confirm-user/'.$order->id)}}"><button type="submit" class="btn btn-primary"> Upload </button></form></td>

	                    				@if ($order->buktibayar!=null)
	                    					<td align="center"><a href="{{ url(Storage::url($order->buktibayar)) }}">View</a></td>
	                    				@else 
	                    					<td align="center">-</td>
	                    				@endif

	                    				@if ($order->konfirmasi==0)
	                    					<td style="color:red;">Belum di konfirmasi</td>
	                    				@elseif ($order->konfirmasi==1)
	                    					<td style="color:green;">Sudah di konfirmasi</td>
	                    				@else 
	                    					<td style="color:red;">Pesanan ditolak</td>
	                    				@endif
	                    			</tr>
	                    		@endforeach
	                    	</tbody>
	                    </table>
                    <?php echo $orders->render(); ?> 
                </div>       
	        </div>    
    	</div>	
	</div>	
</div>
@endsection
