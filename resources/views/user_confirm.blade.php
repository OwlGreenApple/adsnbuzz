@extends('layouts.app')

@section('content')
<script type="text/javascript">
	$( "body" ).on( "click", ".popup-newWindow", function() {
    event.preventDefault();
    window.open($(this).attr("href"), "popupWindow", "width=600,height=600,scrollbars=yes");
  });

	function cari(){
    $.ajax({
      type : 'POST',
      url : "{{url('/confirm-user/search')}}",
      data : $('form').serialize(),
      dataType : 'json',
      success: function(data) {
        if(document.getElementById('search').value != "") {
          console.log(data.status=="not-found");
          if(data.status=="not-found"){
            console.log("failed");
            $('#tabelorder').empty();
            document.getElementById("pesan").innerHTML = '<div class="alert alert-warning"><strong>Warning!</strong> Data order tidak ditemukan. </div>';
          } else {
            console.log("success");
            $('#tabelorder').empty();
            document.getElementById("pesan").innerHTML = '';

            var trHTML = '';
            $.each(data.isi, function (i, item) {
  		        trHTML += '<tr><td>' + item.tgl_order + '</td><td>' + item.no_order + '</td><td>' + item.jml_order + '</td><td>' + item.kodekupon + '</td><td>' + item.totalharga + '</td><td align="center"><form action="<?php echo url('/confirm-user'); ?>' +'/'+ item.id +'"><button type="submit" class="btn btn-primary"> Upload </button></form></td>';

  		        if(item.buktibayar==null){
  		          trHTML += '<td align="center"> - </td>';
  		        } else {
  		          trHTML += '<td align="center"><a class="popup-newWindow" href="<?php echo url('/'); ?>' +'/'+ item.buktibayar +'">View</a></td>';
  		        }

  		        if(item.konfirmasi==0){
  		          trHTML += '<td style="color:red;">Belum di konfirmasi</td></tr>';
  		        } else if (item.konfirmasi==1){
  		          trHTML += '<td style="color:green;">Sudah di konfirmasi</td>';
  		        } else {
  		          trHTML += '<td style="color:red;">Pesanan ditolak</td>';
  		        }
		        });      
            document.getElementById("tabelorder").innerHTML = trHTML;;
            console.log(trHTML);
          }
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
<div class="container-fluid">
	<div class="row">
    <!-- List menu user -->
		<div class="daftarmenu col-md-3">
	    @include('layouts.user')
	  </div>

	  <div class="kontenmenu col-md-9 py-4" id="isiform">
      <!-- Error Message -->
      <div id="pesan"></div>
      <!-- Content -->
	    <div class="card">
	      <div class="card-header">Confirm Payment</div>

        <div class="card-body">
          <form>
            <div class="form-group row">
		          <input type="text" class="form-control col-md-4" name="search" id="search" placeholder="Masukkan no order..." style="margin-left: 14px;">
		          <button type="button" class="btn btn-primary" style="margin-left:10px;" onclick="cari()"> Cari </button>
		        </div>	
          </form>

	        <table class="table table-bordered">
	          <thead align="center">
	            <th>Tanggal Order</th>
	            <th>Nomor Order</th>
	            <th>Jumlah Order</th>
	            <th>Kode Kupon</th>
	            <th>Total Bayar</th>
	            <th colspan="2">Bukti Bayar</th>
	            <th>Status</th>
	          </thead>

	          <tbody id="tabelorder">
	            @foreach ($orders as $order)
  	            <tr>
  	              <td><?php $date=date_create($order->tgl_order); echo date_format($date, "d-m-Y"); ?></td>
  	              <td>{{ $order->no_order }}</td>
  	              <td>Rp. <?php echo number_format("$order->jml_order") ?></td>
  	              <td>{{ $order->kodekupon }}</td>
  	              <td>Rp. <?php echo number_format("$order->totalharga") ?></td>

  	              @if ($order->konfirmasi==1)
  	                <td align="center"><button class="btn btn-primary disabled"> Upload </button></td>
  	              @else 
  	                <td align="center"><form action="{{url('/confirm-user/'.$order->id)}}"><button type="submit" class="btn btn-primary"> Upload </button></form></td>
  	              @endif

  	              @if ($order->buktibayar!=null)
  	                <!--<td align="center"><a class="popup-newWindow" href="{{ url(Storage::url($order->buktibayar)) }}">View</a></td>-->
                    <td align="center"><a class="popup-newWindow" href="{{ url($order->buktibayar) }}">View</a></td>
  	              @else 
  	                <td align="center">-</td>
  	              @endif

  	              @if ($order->konfirmasi==0)
  	                <td style="color:red;">Belum di konfirmasi</td>
  	              @elseif ($order->konfirmasi==1)
  	                <td style="color:green;">Sudah di konfirmasi</td>
  	              @else 
  	                <td style="color:red;">Pesanan ditolak</td>
  	              @endif
  	            </tr>
	            @endforeach
	          </tbody>
	        </table>
          <?php echo $orders->render(); ?> 
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
@endsection
