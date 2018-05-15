@extends('layouts.app')

@section('content')
<script type="text/javascript">
    function saveData(){
        $.ajax({
            type : 'POST',
            url : "{{url('/coupon/')}}",
            data : $('form').serialize(),
            dataType : 'json',
            success: function(data) {
                if(data.status=='error'){
                    console.log("false");
                    document.getElementById("pesan").innerHTML = '<div class="alert alert-warning"><strong>Warning!</strong> '+ data.message +'</div>';
                } else {
                    console.log("success");
                    document.getElementById("pesan").innerHTML = '<div class="alert alert-success"><strong>Success!</strong> Kupon berhasil ditambahkan. </div>';
                    document.getElementById("forminsert").reset();
                }
            }
        });
    }

    $(document).on({
      ajaxStart: function() { 
        document.getElementById("loader").style.display = "block";
        $('div.overlay').addClass('background-load');},
      ajaxStop: function() { 
        document.getElementById("loader").style.display = "none"; 
        $('div.overlay').removeClass('background-load');},
    });
</script>
<div class="container py-4" id="isiform">
    <div class="row justify-content-center">
        <div class="col-md-8">
          <div id="pesan"></div>
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-header">Insert Coupon</div>

                <div class="card-body">
                    <form action="{{url('/coupon')}}" method="post" id="forminsert">
                    	@csrf
                        <div class="form-group row">
                            <label for="kodekupon" class="col-md-4 text-md-right"> Kode Kupon </label>
                            <input type="text" class="form-control col-md-4" name="kodekupon">
                        </div>
                        
                        <div class="form-group row">
                            <label for="tipekupon" class="col-md-4 text-md-right"> Tipe Kupon </label>
                            <select class="form-control col-md-4" name="tipekupon">
                            	<option>Nominal</option>
                                <option>Persen</option>
							</select>
                        </div>
                
                        <div class="form-group row">
                            <label for="diskon" class="col-md-4 col-form-label text-md-right"> Diskon </label>
                            <input type="text" class="form-control col-md-4" name="diskon">
                        </div>

                        <div class="form-group" align="center">
                            <button type="button" class="btn btn-primary" onclick="saveData()"> Tambah </button>
                        </div>
                    </form>
                </div>      
            </div>

            <div id="pesan">  
            </div>
        </div>
    </div>
</div>

<div class="overlay">
  <div id="loader" style="display: none;">
  </div>  
</div>
@endsection