@extends('layouts.app')

@section('content')
<script type="text/javascript">
  function validation(){
    var agencyfee = $('#agencyfee').val();
    var filecsv = $('#filecsv').val();
    var ext = filecsv.split('.').pop().toLowerCase();
    var arr = {status:true, message:''};
    var regx = new RegExp("^[1-9][0-9]*$");

    if(agencyfee=='' || !filecsv){
      arr["status"] = false;
      arr["message"] = 'Isi form terlebih dahulu.';
    } else if (!regx.test(agencyfee)){
      arr["status"] = false;
      arr["message"] = 'Masukkan input hanya angka pada form max spend.';
    } else if (agencyfee>100){
      arr["status"] = false;
      arr["message"] = 'Masukkan diskon antara 0 - 100 untuk tipe persen.';
    } else if ($.inArray(ext, ['csv']) == -1) {
      arr["status"] = false;
      arr["message"] = 'Masukkan file berupa csv.';
    }
    return arr;
  }

  $( "body" ).on( "submit", ".data", function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    var arr = validation();

    if(arr["status"]==false){
      console.log("failed");
      document.getElementById("pesan").innerHTML = '<div class="alert alert-warning"><strong>Warning!</strong> '+ arr["message"] +'</div>';
    } else {
      $.ajax({
        type : 'POST',
        url : "{{url('/report/save')}}",
        data : formData,
        dataType : 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
          if(data.status=='error'){
            console.log("failed");
            document.getElementById("pesan").innerHTML = '<div class="alert alert-warning"><strong>Warning! </strong> '+data.message+'</div>';
          } else {
            console.log("success");
            document.getElementById("pesan").innerHTML = '<div class="alert alert-success"><strong>Success! </strong> File report berhasil diupload. </div>';
          }
        }
      });
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

<div class="container py-4" id="isiform">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div id="pesan"></div>
      
      <div class="card">
        <div class="card-header">Report</div>

        <div class="card-body">
          <form method="post" enctype="multipart/form-data" class="data">
            @csrf
            
            <div class="form-group row">
              <label for="listuser" class="col-md-4 text-md-right"> User </label>
              <input type="text" name="username" value="{{$user->name}}" disabled>
              <input type="hidden" name="userid" value="{{$user->id}}">
            </div>
                
            <div class="form-group row">
              <label for="file" class="col-md-4 col-form-label text-md-right"> File CSV </label>
              <input type="file" name="filecsv" id="filecsv">  
            </div>

            <div class="form-group row">
              <label for="file" class="col-md-4 col-form-label text-md-right"> Agency Fee </label>
              <input type="text" class="form-control col-md-1" name="agencyfee" id="agencyfee" value="20">
              <p class="col-md-1">%</p>
            </div>

            <div class="form-group" align="center">
              <button class="btn btn-primary"> Upload </button>
            </div>
          </form>
        </div>       
      </div>
    </div>
  </div>
</div>

<div class="overlay">
  <div id="loader" style="display: none;">
  </div>  
</div>
@endsection