@extends('layouts.app')

@section('content')
<script type="text/javascript">
	function konfirmasi(orderid){
		$.ajax({
      type : 'GET',
      url : "{{url('/confirm/save')}}",
      data : {orderid:orderid},
      dataType : 'text',
      success: function(response) {
        console.log("success");
        document.getElementById("pesan").innerHTML = '<div class="alert alert-success"><strong>Success!</strong> Pesanan berhasil dikonfirmasi. </div>';
			}
    });
	}

	$( "body" ).on( "click", ".confirm", function() {
	  $(this).replaceWith('<button type="button" class="btn btn-primary unconfirm" onclick="unkonfirmasi('+$(this).attr("data")+')" data="'+$(this).attr("data")+'" > Unconfirm </button>')
	});

	function unkonfirmasi(orderid){
		if(confirm("Unconfirm this order?")) {
			$.ajax({
	      type : 'GET',
	      url : "{{url('/confirm/unsave')}}",
	      data : {orderid:orderid},
	      dataType : 'text',
	      success: function(response) {
	        console.log("success");
	        document.getElementById("pesan").innerHTML = '<div class="alert alert-success"><strong>Success!</strong> Pesanan berhasil diunkonfirmasi. </div>';
	      }
	    });
	  }
	}

	$( "body" ).on( "click", ".unconfirm", function() {
	  $(this).replaceWith('<button type="button" class="btn btn-primary confirm" onclick="konfirmasi('+$(this).attr("data")+')" data="'+$(this).attr("data")+'" > Confirm </button>')
	});

	function rejectt(orderid){
		if(confirm("Reject this order?")) {
			$.ajax({
	      type : 'GET',
	      url : "{{url('/confirm/reject')}}",
	      data : {orderid:orderid},
	      dataType : 'text',
	      success: function(response) {
	        console.log("success");
	        document.getElementById("pesan").innerHTML = '<div class="alert alert-success"><strong>Success!</strong> Pesanan berhasil direject. </div>';
	      }
	    });
	  }
	}

	$( "body" ).on( "click", ".reject", function() {
	  $(this).replaceWith('<button type="button" class="btn btn-primary unreject" onclick="unrejectt('+$(this).attr("data")+')" data="'+$(this).attr("data")+'" > Unreject </button>')
	});

	function unrejectt(orderid){
		$.ajax({
	    type : 'GET',
	    url : "{{url('/confirm/unreject')}}",
	    data : {orderid:orderid},
	    dataType : 'text',
	    success: function(response) {
	      console.log("success");
	      document.getElementById("pesan").innerHTML = '<div class="alert alert-success"><strong>Success!</strong> Pesanan berhasil diunreject. </div>';
	    }
	  });
	}

	$( "body" ).on( "click", ".unreject", function() {
	  $(this).replaceWith('<button type="button" class="btn btn-danger reject" onclick="rejectt('+$(this).attr("data")+')" data="'+$(this).attr("data")+'" > Reject </button>')
	});

	function cari(){
    $.ajax({
      type : 'POST',
      url : "{{url('/confirm/search')}}",
      data : $('form').serialize(),
      dataType : 'json',
      success: function(data) {
        if(document.getElementById('search').value != "") {
          if(data.status=="not-found"){
            console.log("failed");
            $('#tabelorder').empty();
            document.getElementById("pesan").innerHTML = '<div class="alert alert-warning"><strong>Warning!</strong> Data order tidak ditemukan. </div>';
          } else {
            console.log("success");
            $('#tabelorder').empty();
            document.getElementById("pesan").innerHTML = '';

            var trHTML = '';
            console.log(data);
            $.each(data.isi, function (i, item) {
              trHTML += '<tr><td>' + item.tgl_order + '</td><td>' + item.email + '</td><td>' + item.no_order + '</td><td>' + item.jml_order + '</td><td>' + item.totalharga + '</td><td>' + item.kodekupon + '</td><td>' + item.opsibayar + '</td>';

              if(item.buktibayar==null){
                trHTML += '<td align="center"> - </td>';
              } else {
                console.log(item.buktibayar);
                trHTML += '<td align="center"><a class="popup-newWindow" href="<?php echo url('/'); ?>' +'/'+ item.buktibayar +'">View</a></td>';
              }

              if(item.konfirmasi==0){
                trHTML += '<td align="center"><button type="button" class="btn btn-primary confirm" onclick="konfirmasi(' + item.id + ')" data="'+ item.id +'"> Confirm </button></td>';
              } else if (item.konfirmasi==2) {
                trHTML += '<td align="center"><button type="button" id="confirmdis" class="btn btn-primary disabled"> Confirm </button></td>';
              } else {
                trHTML += '<td align="center"><button type="button" class="btn btn-primary unconfirm" onclick="unkonfirmasi('+ item.id +')" data="'+ item.id +'"> Unconfirm </button></td>';
              }
                      
              if(item.konfirmasi!=2){
                trHTML += '<td align="center"><button type="button" class="btn btn-danger reject" onclick="rejectt('+ item.id +')" data="'+item.id+'"> Reject </button></td>';
              } else {
                trHTML += '<td align="center"><button type="button" class="btn btn-primary unreject" onclick="unrejectt('+ item.id +')" data="'+ item.id +'"> Unreject </button></td>';
              }
            });
            
            document.getElementById("tabelorder").innerHTML = trHTML;;
            console.log(trHTML);
          }
        }
      }
    });
  }

	$( "body" ).on( "click", ".popup-newWindow", function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "popupWindow", "width=600,height=600,scrollbars=yes");
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
    <div class="col-md-13">
      <!-- Error message-->
      <div id="pesan"> </div>
      <!-- Content -->
      <div class="card">
        <div class="card-header menuheader">Confirm Payment</div>

        <div class="card-body">
          <form action="" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
              <input type="text" class="form-control col-md-4" name="search" id="search" placeholder="Masukkan no order..." style="margin-left: 14px;">
              <button type="button" class="btn btn-primary" style="margin-left:10px;" onclick="cari()"> Cari </button>
            </div>

            <div class="tabelorder">
              <table class="table table-bordered">
		            <thead align="center">
		              <th>Tanggal Order</th>
		              <th>Email User</th>
		              <th>Nomor Order</th>
		              <th>Jumlah Order</th>
		              <th>Total Harga</th>
		              <th>Kode Kupon</th>
		              <th>Opsi Bayar</th>
		              <th>Bukti Bayar</th>
		              <th colspan="2">Konfirmasi</th>
		            </thead>
		            <tbody id="tabelorder">
		              @foreach ($orders as $order)
		                <tr>
		                  <td>{{ $order->tgl_order }}</td>
		                  <td>{{ $order->email }}</td>
		                  <td>{{ $order->no_order }}</td>
		                  <td>Rp. <?php echo number_format("$order->jml_order") ?></td>
		                  <td>Rp. <?php echo number_format("$order->totalharga") ?></td>
		                  <td>{{ $order->kodekupon }}</td>
		                  <td>{{ $order->opsibayar }}</td>
		                  @if ($order->buktibayar!=null)
		                    <!--<td align="center"><a class="popup-newWindow" href="{{ url(Storage::url($order->buktibayar)) }}">View</a></td>-->
                        <td align="center"><a class="popup-newWindow" href="{{ url($order->buktibayar) }}">View</a></td>
		                  @else 
		                    <td align="center">-</td>
		                  @endif

		                  @if ($order->konfirmasi==0)
		                    <td align="center"><button type="button" class="btn btn-primary confirm" onclick="konfirmasi({{$order->id}})" data="{{$order->id}}"> Confirm </button></td>
		                  @elseif ($order->konfirmasi==2)
		                    <td align="center"><button type="button" id="confirmdis" class="btn btn-primary disabled"> Confirm </button></td>
		                  @else 
		                    <td align="center"><button type="button" class="btn btn-primary unconfirm" onclick="unkonfirmasi({{$order->id}})" data="{{$order->id}}"> Unconfirm </button></td>
		                  @endif

		                  @if ($order->konfirmasi!=2)
		                    <td align="center"><button type="button" class="btn btn-danger reject" onclick="rejectt({{$order->id}})" data="{{$order->id}}"> Reject </button></td>
		                  @else
		                    <td align="center"><button type="button" class="btn btn-primary unreject" onclick="unrejectt({{$order->id}})" data="{{$order->id}}"> Unreject </button></td>
		                  @endif
		                </tr>
		              @endforeach
		            </tbody>
	            </table>
            </div>
          </form>
          <?php echo $orders->render(); ?> 
        </div>       
      </div>
    </div>
  </div>
</div>

<!-- Loading bar -->
<div class="overlay">
  <div id="loader" style="display: none;">
  </div>  
</div>
@endsection
