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
		dataType : 'text',
		success: function(response) {
			console.log("success");
			$("#isiform").hide();
			$('#pesan').html("Order Telah Tersimpan. <br> Silahkan lakukan pembayaran terlebih dahulu.");
		}
	});
}
function calcCoupon(){
	$.ajax({
		type : 'POST',
		url : "{{url('/calc-coupon')}}",
		data : $('form').serialize(),
		dataType: 'text',
		success: function(response) {
			var data = jQuery.parseJSON(response);
			if(data.type=='found') {
				console.log("a");
				$("#total-price").html(parseInt($("#jml-order").val()) - parseInt(data.value));
			}
			else if(data.type=='not-found') {
				console.log("b");
			}
		}
	});
}
</script>

<div class="container" id="isiform">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Order</div>

                <div class="card-body">
                    <form action="">
                    	@csrf
                        <div class="form-group row">
                            <label for="jml_order" class="col-sm-4 text-md-right"> Jumlah Order </label>
                            <select class="form-control col-md-4" name="jml_order" id="jml-order">
                            	<option>--Pilih Jumlah Order--</option>
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
                            	<option>--Pilih Opsi Pembayaran--</option>
															<option>Transfer Bank</option>
															<option>Credit Card</option>
														</select>  
                        </div>

                        <div class="form-group row">
                            <label for="opsibayar" class="col-md-4 col-form-label text-md-right"> Kode kupon</label>
														<input type="text" class="form-control col-md-4" name="coupon_code">
														&nbsp
														<button type="button" class="btn btn-primary" onclick="calcCoupon()"> Calculate </button>
                        </div>

                        <div class="form-group row">
                            <label for="total-price" class="col-md-4 col-form-label text-md-right"> Total Price</label>
														<span id="total-price"></span>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="button" class="btn btn-primary" onclick="sendData()"> Order </button>
                            </div>
                        </div>

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
@endguest
@endsection
