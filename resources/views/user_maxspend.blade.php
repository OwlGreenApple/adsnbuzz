@extends('layouts.app')

@section('content')
@guest
@else
<script type="text/javascript">
  function validation(){
    var spend = $('#spend').val();
    var arr = {status:true, message:''};
    var regx = new RegExp("^[1-9][0-9]*$");
    if(spend==''){
      arr["status"] = false;
      arr["message"] = 'Isi form terlebih dahulu.';
    } else if (!regx.test(spend)){
      arr["status"] = false;
      arr["message"] = 'Masukkan input hanya angka pada form max spend.';
    } 
    return arr;
  }

  function pesan(){
    var arr = validation();
    if(arr["status"]==false) {
      console.log("failed");
      document.getElementById("pesan").innerHTML = '<div class="alert alert-warning"><strong>Warning!</strong> '+ arr["message"] +'</div>';
    } else {
      $.ajax({
        type : 'POST',
        url : "{{url('/pesan/'.Auth::user()->id)}}",
        data : $('form').serialize(),
        dataType : 'json',
        success: function(data) {
          if(data.status=='error'){
            console.log("false");
            document.getElementById("pesan").innerHTML = '<div class="alert alert-warning"><strong>Warning!</strong> '+ data.message +'</div>';
          } else {
            console.log("success");
            document.getElementById("pesan").innerHTML = '<div class="alert alert-success"><strong>Success!</strong> '+ data.message +'</div>';
          }
        }
      });
    }
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

  $(document).on({
    ajaxStart: function() { 
      document.getElementById("loader").style.display = "block";
      $('div.overlay').addClass('background-load');},
    ajaxStop: function() { 
      document.getElementById("loader").style.display = "none"; 
      $('div.overlay').removeClass('background-load');},
  });
</script>
<div class="container-fluid">
  <div class="row">
    <!-- List menu user -->
    <div class="daftarmenu col-md-3">
      @include('layouts.user')
    </div>

    <div class="kontenmenu col-md-9 py-4" id="isiform">
      <div class="col-md-8 offset-md-2">
        <!-- Error Message -->
        <div id="pesan"> </div>
        <!-- Content -->
        <div class="card">
          <div class="card-body">
            <form action="" id="formpesan">
              @csrf
              <div class="form-group row">
                @if ($user->spend_month==0)
                  <label for="spend" class="col-md-4 text-md-right"> Setup Spend Bulan 1 </label>
                @else 
                  <label for="spend" class="col-md-4 text-md-right"> Max Spend </label>
                  <a class="tooltips"><img src="{{ asset('design/blue_question_mark.png') }}" height="13px">
                    <span>Perubahan Max Spend berlaku bulan depan</span>
                  </a>
                @endif
                <input type="text" class="form-control" id="spend" name="spend" style="margin-left: 10px; width: 274px;" value="{{ $user->spend_month}}" required>
              </div>
                                  
              <div class="form-group row">
                <label for="opsibayar" class="col-md-4 col-form-label text-md-right"> Company Category </label>
                <textarea class="col-md-6" id="companycategory" name="companycategory" placeholder="Categories of your company..."> </textarea>
              </div>

              <div align="center">
                <button type="button" class="btn btn-primary" onclick="pesan()"> Pesan </button>
              </div>
            </form>
          </div>                        
        </div>  
      </div>
    </div>
  </div>
</div>

<!-- Loading Bar -->
<div class="overlay">
  <div id="loader" style="display: none;">
  </div>  
</div>
@endguest
@endsection