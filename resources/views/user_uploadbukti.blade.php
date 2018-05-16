@extends('layouts.app')

@section('content')
<script type="text/javascript">
  function validation(){
    var buktibayar = $('#buktibayar').val();
    var ext = buktibayar.split('.').pop().toLowerCase();
    var arr = {status:true, message:''};

    if(!buktibayar){
      arr["status"] = false;
      arr["message"] = 'Pilih file terlebih dahulu.';
    } else if ($.inArray(ext, ['jpg','jpeg','png','bmp']) == -1) {
      arr["status"] = false;
      arr["message"] = 'File yang Anda masukkan salah.';
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
        url : "{{url('/confirm-user/save/'.$order->id)}}",
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
            document.getElementById("pesan").innerHTML = '<div class="alert alert-success"><strong>Success! </strong>'+data.message+'</div>';
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
<div class="container-fluid">
  <div class="row">
    <div class="daftarmenu col-md-3">
      @include('layouts.user')
    </div>

    <div class="kontenmenu col-md-9 py-4" id="isiform">
      <div class="col-md-10 offset-md-1">
        @if(session()->has('message'))
	        @if(session()->get('message')=='File berhasil diupload')
        		<div class="alert alert-success">
        			<strong>Success! </strong>
              {{ session()->get('message') }}
        		</div>
          @else
          	<div class="alert alert-warning">
              <strong>Warning! </strong>
          		{{ session()->get('message') }}
          	</div>
          @endif
				@endif

        <div id="pesan"></div>
        <div class="card">
          <div class="card-header">Upload Bukti Bayar</div>

	        <div class="card-body">
	          <form method="post" enctype="multipart/form-data" class="data">
	            @csrf
		          <div class="form-group">
		            <h3><strong>Informasi Order</strong></h3>
		            <p>Tanggal Order 	= {{$order->tgl_order}}</p>
		            <p>Jumlah Order		= Rp. <?php echo number_format("$order->jml_order") ?></p>
		            <p>Kode Kupon		= {{$order->kodekupon}}</p>
		            <p>Opsi Bayar 		= {{$order->opsibayar}}</p>
		          </div>
		          
              <div class="form-group">
		            <input id="buktibayar" name="buktibayar" type="file" id="buktibayar"/>	
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
</div>

<div class="overlay">
  <div id="loader" style="display: none;">
  </div>  
</div>
@endsection
