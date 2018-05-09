@extends('layouts.app')

@section('content')
@guest
@else
<script type="text/javascript">
	function sendData(){
		$.ajax({
			type : 'POST',
			url : "{{url('/order/'.Auth::user()->id)}}",
			data : $('form').serialize(),
			dataType : 'json',
			success: function(data) {
				if(data=='failed'){
					alert("Kode kupon tidak ditemukan");
				} else {
					console.log("success");
					//$("#isiform").reset();
					document.getElementById("isidata").innerHTML = "<p>Order telah tersimpan.<br> Silahkan lakukan pembayaran terlebih dahulu.</p><p><strong>Detail Deposit</strong>: </p><p>Tanggal order = "+ data.tgl_order +"</p><p>Jumlah deposit = " + data.jml_order + "</p><p>Kode kupon = " + data.kodekupon + "</p><p>Total harga = " + data.totalharga + "</p>";
				}
			}
		});
	}
</script>

<div class="container-fluid">
	<div class="row">
		<div class="daftarmenu col-md-3">
	        @include('layouts.user')
	    </div>

	    <div class="kontenmenu col-md-9 py-4" id="isiform">
	    	<div class="col-md-8 offset-md-2">
	            <div class="card">
	                <div class="card-header">Deposit</div>

	                <div class="card-body" id="isidata">
	                    <form action="{{url('/order/'.Auth::user()->id)}}" method="post" id="isiform">
	                    	@csrf
	                        <div class="form-group row">
	                            <label for="jml_order" class="col-sm-4 text-md-right"> Jumlah Deposit </label>
	                            <select class="form-control col-md-4" name="jml_order" id="jml-order">
									<option value="5000000">5 juta</option>
									<option value="10000000">10 juta</option>
									<option value="15000000">15 juta</option>
									<option value="20000000">20 juta</option>
									<option value="25000000">25 juta</option>
									<option value="50000000">50 juta</option>
									<option value="100000000">100 juta</option>
								</select>
	                        </div>
	                

	                        <div class="form-group row">
	                            <label for="opsibayar" class="col-md-4 col-form-label text-md-right"> Opsi Pembayaran </label>
	                            <select class="form-control col-md-4" name="opsibayar" id="opsi-bayar">
										<option>Transfer Bank</option>
										<option>Credit Card</option>
								</select>  
	                        </div>

	                        <div class="form-group row">
	                            <label for="opsibayar" class="col-md-4 col-form-label text-md-right"> Kode kupon</label>
								<input type="text" class="form-control col-md-4" name="coupon_code"> &nbsp
	                        </div>

	                        <div class="form-group" align="center" style="margin-top: 50px;">
	                            <div class="col-md-8">
	                                <button type="button" class="btn btn-primary" onclick="sendData()"> Order </button>
	                            </div>
	                        </div>

	                    </form>
	                </div>       
	            </div>
	        </div>    
    	</div>	
	</div>	
</div>
@endguest
@endsection
