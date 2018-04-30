@extends('layouts.app')

@section('content')
@guest
@else
<script type="text/javascript">
    function pesan(){
        $.ajax({
            type : 'POST',
            url : "{{url('/pesan/'.Auth::user()->id)}}",
            data : $('form').serialize(),
            dataType : 'text',
            success: function(response) {
                if(response=='invalid'){
                    console.log("false");
                    alert("Jumlah pesan terlalu besar. Silahkan deposit terlebih dahulu.");
                } else {
                    console.log("success");
                    alert("Pesanan tersimpan");
                    document.getElementById("formpesan").reset();
                }
            }
        });
    }
$(document).ready(function() {
    $('#companycategory').selectize({
            plugins: ['remove_button'],
            delimiter: ',',
            persist: false,
            create: function(input) {
                return {
                    value: input,
                    text: input
                }
            }
    });
});
</script>
<div class="container" id="isiform">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="" id="formpesan">
                        @csrf
                        <div class="form-group row">
                            <label for="spend" class="col-sm-4 text-md-right"> Spend </label>
                            <input type="text" class="form-control col-md-4" name="spend">
                        </div>
                

                        <div class="form-group row">
                            <label for="opsibayar" class="col-md-4 col-form-label text-md-right"> Company Category </label>
                            <textarea class="form-control col-md-4" id="companycategory"> </textarea>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="button" class="btn btn-primary" onclick="pesan()"> Pesan </button>
                            </div>
                        </div>

                    </form>
                </div>   
            </div>
        </div>
    </div>
</div>
@endguest
@endsection
