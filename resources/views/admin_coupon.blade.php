@extends('layouts.app')

@section('content')
<script type="text/javascript">
  function validation(){
    var diskon = $('#diskon').val();
    var kupon = $('#kupon').val();
    var tipe = $('#tipe').val();
    var arr = {status:true, message:''};
    var regx = new RegExp("^[1-9][0-9]*$");

    if(diskon=='' || kupon==''){
      arr["status"] = false;
      arr["message"] = 'Isi form terlebih dahulu.';
    } else if (!regx.test(diskon)){
      arr["status"] = false;
      arr["message"] = 'Masukkan input hanya angka pada form max spend.';
    } else if (tipe=='Persen' && diskon>100){
      arr["status"] = false;
      arr["message"] = 'Masukkan diskon antara 0 - 100 untuk tipe persen.';
    }
    return arr;
  }

  function saveData(){
    var arr = validation();
    if(arr["status"]==false){
      console.log("failed");
      document.getElementById("pesanmodal").innerHTML = '<div class="alert alert-warning"><strong>Warning!</strong> '+ arr["message"] +'</div>';
    } else {
      $.ajax({
        type : 'POST',
        url : "{{url('/coupon/')}}",
        data : $('form').serialize(),
        dataType : 'json',
        success: function(data) {
        if(data.status=='error'){
          console.log("false");
          document.getElementById("pesanmodal").innerHTML = '<div class="alert alert-warning"><strong>Warning!</strong> '+ data.message +'</div>';
        } else {
          console.log("success");
          document.getElementById("pesanmodal").innerHTML = '<div class="alert alert-success"><strong>Success!</strong> Kupon berhasil ditambahkan. </div>';
          $('<tr><td>'+data.isi.kodekupon+'</td><td>'+data.isi.diskon+'</td><td>'+data.isi.tipekupon+'</td><td align="center"><button class="btn btn-primary" data-toggle="modal" data-target="#modalKupon" data-kode="'+data.isi.kodekupon+'" data-diskon="'+data.isi.diskon+'" data-tipe="'+data.isi.tipekupon+'" data-id="'+data.isi.id+'" data-action="update">Update</td><td align="center"><button class="btn btn-danger" onclick="deleteData('+data.isi.id+',this)">Delete</td></tr>').prependTo("table > tbody");
        }
        }
      });
    }
  }

  function editData(id){
    var arr = validation();
    if(arr["status"]==false){
      console.log("failed");
      document.getElementById("pesan").innerHTML = '<div class="alert alert-warning"><strong>Warning!</strong> '+ arr["message"] +'</div>';
    } else {
      $.ajax({
        type : 'PUT',
        url : "<?php echo url('/coupon'); ?>"+'/'+id,
        data : $('form').serialize(),
        dataType : 'json',
        success: function(data) {
          if(data.status=='error'){
            console.log("false");
            document.getElementById("pesanmodal").innerHTML = '<div class="alert alert-warning"><strong>Warning!</strong> '+data.message+'</div>';
          } else {
            console.log("success");
            document.getElementById("pesanmodal").innerHTML = '<div class="alert alert-success"><strong>Success!</strong> Kupon berhasil diupdate. </div>';
            $('.id-'+id).html('<td>'+data.isi.kodekupon+'</td><td>'+data.isi.diskon+'</td><td>'+data.isi.tipekupon+'</td><td align="center"><button class="btn btn-primary updatebtn" data-toggle="modal" data-target="#modalKupon" data-kode="'+data.isi.kodekupon+'" data-diskon="'+data.isi.diskon+'" data-tipe="'+data.isi.tipekupon+'" data-id="'+data.isi.id+'" data-action="update">Update</td><td align="center"><button class="btn btn-danger" onclick="deleteData('+data.isi.id+',this)">Delete</td>');
          }
        }
      });
    }
  }

  function deleteData(id,row){
    if(confirm("Are you sure want to delete?")) {
      $.ajax({
        type : 'DELETE',
        url : "<?php echo url('/coupon'); ?>"+'/'+id,
        data: { "_token": "{{ csrf_token() }}" },
        //dataType : 'text',
        beforeSend: function(){
          document.getElementById("loader").style.display = "block";
          $('div.overlay').addClass('background-load');  
        },
        success: function(response) {
          console.log("success");
          document.getElementById("pesan").innerHTML = '<div class="alert alert-success"><strong>Success!</strong> Kupon berhasil dihapus. </div>';

          document.getElementById("loader").style.display = "none"; 
          $('div.overlay').removeClass('background-load');

          var el = row.parentNode.parentNode.rowIndex;
          console.log(el);
          document.getElementById("tabel").deleteRow(el);
        }
      });
    }
  }

  function cari(){
    $.ajax({
      type : 'GET',
      url : "<?php echo url('/coupon'); ?>"+'/'+ document.getElementById('search').value,
      data : $('form').serialize(),
      dataType : 'json',
      beforeSend: function(){
        document.getElementById("loader").style.display = "block";
        $('div.overlay').addClass('background-load');  
      },
      success: function(data) {
        if(document.getElementById('search').value != "") {
          if(data.status=="not-found"){
            console.log("failed");
            $('#tabelkupon').empty();
            document.getElementById("pesan").innerHTML = '<div class="alert alert-warning"><strong>Warning!</strong> Kupon tidak ditemukan. </div>';
          } else {
            console.log("success");
            $('#tabelkupon').empty();
            document.getElementById("pesan").innerHTML = '';
            console.log(data.isi);
            var trHTML = '';
            $.each(data.isi, function (i, item) {
              trHTML += '<tr><td>'+item.kodekupon+'</td><td>'+item.diskon+'</td><td>'+item.tipekupon+'</td><td align="center"><button class="btn btn-primary updatebtn" data-toggle="modal" data-target="#modalKupon" data-kode="'+item.kodekupon+'" data-diskon="'+item.diskon+'" data-tipe="'+item.tipekupon+'" data-id="'+item.id+'" data-action="update">Update</td><td align="center"><button class="btn btn-danger" onclick="deleteData('+item.id+',this)">Delete</td></tr>';

            });
            
            document.getElementById("tabelkupon").innerHTML = trHTML;;
            console.log(trHTML);
          }
        }
        
        document.getElementById("loader").style.display = "none"; 
        $('div.overlay').removeClass('background-load');
      }
    });
  }

  $(document).ready(function() {

    $("#myTable").tablesorter({
      headers: {
        3: { sorter:false },
      }
    }); 

    $("#modalKupon").on("show.bs.modal", function(e) {
      document.getElementById("pesanmodal").innerHTML='';
      var action = $(e.relatedTarget).data('action');

      if(action=="tambah"){
        console.log("add");
        $(this).find('#kupon').val('');
        $(this).find('#diskon').val('');
        $(this).find('#tipe').val('Nominal');
        document.getElementById("modaltitle").innerHTML = "Tambah Kupon";
        document.getElementById("foot").innerHTML = '<button type="button" class="btn btn-primary" onclick="saveData()"> Tambah </button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
      } else {
        console.log("update");
        var row = $(e.relatedTarget).closest("tr");
        var kode = $(e.relatedTarget).data('kode');
        var diskon = $(e.relatedTarget).data('diskon');
        var tipe = $(e.relatedTarget).data('tipe');
        var id = $(e.relatedTarget).data('id');
        //console.log(id);
        $(this).find('#kupon').val(kode);
        $(this).find('#diskon').val(diskon);
        $(this).find('#tipe').val(tipe);
        document.getElementById("modaltitle").innerHTML = "Update Kupon";
        document.getElementById("foot").innerHTML = '<button type="button" class="btn btn-primary" onclick="editData('+id+')"> Update </button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
      }
    });
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

<style type="text/css">
  th.header {   
    background-image: url("design/sorter.png");
    cursor: pointer; 
    background-repeat: no-repeat; 
    background-position: center right 5px; 
  }
  th.headerSortUp { 
    background-image: url("design/sorterdesc.png"); 
    background-color: #5496d8; 
  }  
  th.headerSortDown { 
    background-image: url("design/sorterasc.png"); 
    background-color: #5496d8; 
} 
</style>
<div class="container" id="isiform">
  <div class="row justify-content-center">
    <div class="col-md-8 py-4">
      <!-- Error Message -->
      <div id="pesan"> </div>
      <!-- Content -->
      <div class="card">
        <div class="card-header">Coupon Management</div>

        <div class="card-body">
          <form>
            <div class="row" style="margin-bottom: 15px;">
              <div class="col-md-2">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalKupon" data-action="tambah">Tambah    
              </div>
                            
              <div class="col-md-6 offset-md-4 row">
                <button type="button" class="btn btn-primary" style="margin-left: 10px;" onclick="cari()"> Cari </button>
                <input type="text" class="form-control col-md-9" name="search" id="search" placeholder="Masukkan kode kupon..." style="margin-left: 20px;">
              </div>
            </div>
          </form>
                    
          <div class="tabel">
            <table class="tablesorter table table-striped table-bordered" id="myTable">
              <thead style="text-align: center;">
                <th>Kode Kupon</th>
                <th>Diskon</th>
                <th>Tipe Kupon</th>
                <th colspan="2">Edit</th>
              </thead>

              <tbody id="tabelkupon">
                @foreach ($coupons as $coupon)
                  <tr class="id-{{$coupon->id}}">
                    <td>{{ $coupon->kodekupon }}</td>
                    <td>{{ $coupon->diskon }}</td>
                    <td>{{ $coupon->tipekupon }}</td>
                    <td align="center"><button class="btn btn-primary updatebtn" data-toggle="modal" data-target="#modalKupon" data-kode="{{ $coupon->kodekupon }}" data-diskon="{{ $coupon->diskon }}" data-tipe="{{ $coupon->tipekupon }}" data-id="{{ $coupon->id }}" data-action="update">Update
                    </td>
                    <td align="center"><button class="btn btn-danger" onclick="deleteData({{ $coupon->id }},this)">Delete</td>
                  </tr>
                @endforeach
              </tbody>
            </table>    
          </div>
          <?php echo $coupons->render(); ?> 
        </div>       
      </div>
    </div>
  </div>
</div>

<!-- Modal Kupon -->
<div class="modal fade" id="modalKupon" role="dialog">
  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle"></h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div id="pesanmodal"></div>
        <form action="{{url('/coupon')}}" method="post">
          @csrf
          <div class="form-group row">
            <label for="kodekupon" class="col-md-4 text-md-right"> Kode Kupon </label>
            <input type="text" class="form-control col-md-6" name="kodekupon" id="kupon">
          </div>
                        
          <div class="form-group row">
            <label for="tipekupon" class="col-md-4 text-md-right"> Tipe Kupon </label>
            <select class="form-control col-md-6" name="tipekupon" id="tipe">
              <option>Nominal</option>
              <option>Persen</option>
            </select>
          </div>
                
          <div class="form-group row">
            <label for="diskon" class="col-md-4 col-form-label text-md-right"> Diskon </label>
            <input type="text" class="form-control col-md-6" name="diskon" id="diskon">
          </div>
        </form>
      </div>
      <div class="modal-footer" id="foot">
    
      </div>
    </div>
      
  </div>
</div>

<!--Loading Bar-->
<div class="overlay">
  <div id="loader" style="display: none;">
  </div>  
</div>
@endsection