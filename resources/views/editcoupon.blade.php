@extends('layouts.app')

@section('content')
<script type="text/javascript">
    function editData(id){
        $.ajax({
            type : 'PUT',
            url : "<?php echo url('/coupon'); ?>"+'/'+id,
            data : $('form').serialize(),
            dataType : 'text',
            success: function(response) {
                if(response=='not-valid'){
                    console.log("false");
                    alert("Masukkan diskon antara 0 - 100 untuk tipe persen.")
                } else {
                    console.log("success");
                    $("#pesan").addClass("alert alert-success alert-dismissible");
                    $("#pesan").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
                    $("#pesan").append("<strong>Success!</strong> Kupon berhasil diupdate.");
                }
            }
        });
    }
</script>
<div class="container" id="isiform">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-header">Edit Coupon</div>

                <div class="card-body">
                    <form action="{{url('/coupon')}}" method="post" id="forminsert">
                    	@csrf
                        <div class="form-group row">
                            <label for="kodekupon" class="col-md-4 text-md-right"> Kode Kupon </label>
                            <input type="text" class="form-control col-md-4" name="kodekupon" value="<?php echo $coupon->kodekupon; ?>">
                        </div>
                        
                        <div class="form-group row">
                            <label for="tipekupon" class="col-md-4 text-md-right"> Tipe Kupon </label>
                            <select class="form-control col-md-4" name="tipekupon">
                                @if ($coupon->tipekupon=='Nominal')
                            	    <option selected>Nominal</option>
                                    <option>Persen</option>
                                @else 
                                    <option>Nominal</option>
                                    <option selected>Persen</option>
                                @endif
							</select>
                        </div>
                
                        <div class="form-group row">
                            <label for="diskon" class="col-md-4 col-form-label text-md-right"> Diskon </label>
                            <input type="text" class="form-control col-md-4" name="diskon" value="<?php echo $coupon->diskon; ?>">
                        </div>

                        <div class="form-group" align="center">
                            <button type="button" class="btn btn-primary" onclick="editData({{$coupon->id}})"> Update </button>
                        </div>
                    </form>
                </div>      
            </div>

            <div id="pesan">  
            </div>
        </div>
    </div>
</div>
@endsection