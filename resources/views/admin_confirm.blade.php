@extends('layouts.app')

@section('content')
<script type="text/javascript">
	function konfirmasi(order){
		$.ajax({
            type : 'GET',
            url : "{{url('/confirm/save')}}",
            data : {order:order},
            dataType : 'text',
            success: function(response) {
                console.log("success");
                alert("Pesanan sudah terkonfirmasi");
            }
        });
	}

	function unkonfirmasi(order){
		if(confirm("Unconfirm this order?")) {
			$.ajax({
	            type : 'GET',
	            url : "{{url('/confirm/unsave')}}",
	            data : {order:order},
	            dataType : 'text',
	            success: function(response) {
	                console.log("success");
	                alert("Pesanan sudah di unkonfirmasi");
	            }
	        });
	    }
	}

	function rejectt(order){
		if(confirm("Reject this order?")) {
			$.ajax({
	            type : 'GET',
	            url : "{{url('/confirm/reject')}}",
	            data : {order:order},
	            dataType : 'text',
	            success: function(response) {
	                console.log("success");
	                alert("Pesanan sudah direject");
	            }
	        });
	    }
	}

	function unrejectt(order){
		$.ajax({
	        type : 'GET',
	        url : "{{url('/confirm/unreject')}}",
	        data : {order:order},
	        dataType : 'text',
	        success: function(response) {
	            console.log("success");
	            alert("Pesanan berhasil di unreject");
	        }
	    });
	}

	function cari(){
		$.ajax({
	        type : 'POST',
	        url : "{{url('/confirm/search')}}",
	        data : $('form').serialize(),
	        dataType : 'json',
	        success: function(data) {
	            if(data=="not-found"){
	            	console.log("failed");
	            	$('#tabelorder tbody').empty();
	            } else {
	            	console.log("success");
	            	$('#tabelorder tbody').empty();

	                var trHTML = '';
	                trHTML += '<tr><td>' + data.tgl_order + '</td><td>' + data.no_order + '</td><td>' + data.jml_order + 
	                    '</td><td>' + data.kodekupon + '</td><td>' + data.opsibayar + '</td><td align="center"><a href="' + "<?php echo url(Storage::url()); ?>" + data.buktibayar + '">View</a></td></tr>';
	                
	                $('#tabelorder tbody').replaceWith(trHTML);
	            }
	        }
	    });
	}
</script>
<div class="container" id="isiform">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Confirm Payment</div>

                <div class="card-body">
                	<form action="" enctype="multipart/form-data">
                		@csrf
                		<div class="form-group row">
                            <input type="text" class="form-control col-md-4" name="search" placeholder="Masukkan no order..." style="margin-left: 14px;">
                            <button type="button" class="btn btn-primary" style="margin-left:10px;" onclick="cari()"> Cari </button>
                		</div>

                		<div class="tabelorder" id="tabelorder">
                			<table class="table table-bordered">
		                    	<thead align="center">
		                    		<th>Tanggal Order</th>
		                    		<th>Nomor Order</th>
		                    		<th>Jumlah Order</th>
		                    		<th>Kode Kupon</th>
		                    		<th>Opsi Bayar</th>
		                    		<th>Bukti Bayar</th>
		                    		<th colspan="2">Konfirmasi</th>
		                    	</thead>
		                    	<tbody>
		                    		@foreach ($orders as $order)
		                    			<tr>
		                    				<td>{{ $order->tgl_order }}</td>
		                    				<td>{{ $order->no_order }}</td>
		                    				<td>Rp. <?php echo number_format("$order->jml_order") ?></td>
		                    				<td>{{ $order->kodekupon }}</td>
		                    				<td>{{ $order->opsibayar }}</td>
		                    				@if ($order->buktibayar!=null)
		                    					<td align="center"><a href="{{ url(Storage::url($order->buktibayar)) }}">View</a></td>
		                    				@else 
		                    					<td align="center">-</td>
		                    				@endif

		                    				@if ($order->konfirmasi==0)
		                    					<td align="center"><button type="button" id="confirm" class="btn btn-primary" onclick="konfirmasi({{$order}})"> Confirm </button></td>
		                    				@elseif ($order->konfirmasi==2)
		                    					<td align="center"><button type="button" id="confirmdis" class="btn btn-primary disabled"> Confirm </button></td>
		                    				@else 
		                    					<td align="center"><button type="button" id="unconfirm" class="btn btn-primary" onclick="unkonfirmasi({{$order}})"> Unconfirm </button></td>
		                    				@endif

		                    				@if ($order->konfirmasi!=2)
		                    					<td align="center"><button type="button" id="reject" class="btn btn-danger" onclick="rejectt({{$order}})"> Reject </button></td>
		                    				@else
		                    					<td align="center"><button type="button" id="unreject" class="btn btn-danger" onclick="unrejectt({{$order}})"> Unreject </button></td>
		                    				@endif
		                    			</tr>
		                    		@endforeach
		                    	</tbody>
	                    	</table>
                		</div>
                    </form>
                    <?php echo $orders->render(); ?> 
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
