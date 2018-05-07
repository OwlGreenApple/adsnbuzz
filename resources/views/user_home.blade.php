@extends('layouts.app')

@section('content')
@guest
@else
<link href="{{ asset('css/user_home.css') }}" rel="stylesheet">

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
                }
            }
        });
    }

    $(document).ready(function() {
        $('#companycategory').selectize({
            plugins: ['remove_button'],
            delimiter: ';',
            persist: false,
            create: function(input) {
                return {
                    value: input,
                    text: input
                }
            }
        });

        var selectize_tags = $("#companycategory")[0].selectize
            selectize_tags.addOption({text:'foo', value: 'foo'});
            selectize_tags.addOption({text:'fii', value: 'fii'});
            selectize_tags.addOption({text:'doo', value: 'doo'});

        var tags = "{{$user->companycategory}}".split(";");
        if(tags!=""){
            for (var i = 0, n = tags.length; i < n; i++) {
                selectize_tags.addOption({ text: tags[i], value:tags[i] });
            }
            selectize_tags.setValue(tags);
        }
    });
</script>
    <div class="divv col-md-3" style="background-color: white; float: left; border-style: solid;">
            @include('layouts.user')
    </div>

    <div class="divv col-md-9 backgrounduser" id="isiform" style="float: right; border-style: solid;">
        <form action="" id="formpesan">
            @csrf
            <div class="form-group row">
                @if ($user->spend_month==0)
                    <label for="spend" class="col-md-3 text-md-right"> Setup Spend Bulan 1 </label>
                @else 
                    <label for="spend" class="col-md-3 text-md-right"> Max Spend </label>
                    <a class="tooltips"><img src="blue_question_mark.png" height="13px">
                    <span>Perubahan Max Spend berlaku bulan depan</span></a>
                @endif
                <input type="text" class="form-control col-md-6" id="spend" name="spend" style="margin-left: 10px;" value="{{ $user->spend_month}}">
            </div>
                
            <div class="form-group row">
                <label for="opsibayar" class="col-md-3 col-form-label text-md-right"> Company Category </label>
                <textarea class="col-md-6" id="companycategory" name="companycategory" placeholder="Categories of your company..."> </textarea>
            </div>

            <div align="center">
                <div>
                    <button type="button" class="btn btn-primary" onclick="pesan()"> Pesan </button>
                </div>
            </div>
        </form>
    </div>

@endguest
@endsection