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
				if(response=='failed'){
					alert("Kode kupon tidak ditemukan");
				} else {
					console.log("success");
					//$("#isiform").reset();
					alert("Order Telah Tersimpan. Silahkan lakukan pembayaran terlebih dahulu.");
				}
			}
		});
	}
	function calcCoupon(){
		var jmlorder = $("#jml-order").val();
		$.ajax({
			type : 'POST',
			url : "{{url('/calc-coupon')}}",
			data : $('form').serialize() + '&jmlorder=' + jmlorder,
			dataType: 'text',
			success: function(data) {
				//var data = jQuery.parseJSON(response);
				if(data == 'not-found') {
					alert('Kode kupon tidak ditemukan');	
				}
				else {
					$("#total-price").html(data);
				}
			}
		});
	}
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Order</div>

                <div class="card-body">
                    <form action="{{url('/order/'.Auth::user()->id)}}" method="post" id="isiform">
                    	@csrf
                        <div class="form-group row">
                            <label for="jml_order" class="col-sm-4 text-md-right"> Jumlah Order </label>
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
							<button type="button" class="btn btn-primary" onclick="calcCoupon()"> Calculate </button>
                        </div>

                        <div class="form-group row">
                            <label for="total-price" class="col-md-4 col-form-label text-md-right"> Total Price</label>
														<span id="total-price" name="totalprice"></span>
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
