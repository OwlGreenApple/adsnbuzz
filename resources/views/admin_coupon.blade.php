@extends('layouts.app')

@section('content')
<script type="text/javascript">
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

                        var trHTML = '';
                        trHTML += '<tr><td>' + data.isi.kodekupon + '</td><td>' + data.isi.diskon + '</td><td>' + data.isi.tipekupon + '</td><td align="center"><form action="<?php echo url('/coupon'); ?>' +'/'+ data.isi.id +'/edit"><button class="btn btn-primary">Update</form></td><td align="center"><button class="btn btn-danger" onclick="deleteData('+ data.isi.id +',this)">Delete</td></tr>';

                        document.getElementById("tabelkupon").innerHTML = trHTML;;
                        console.log(trHTML);
                    }
                }
              document.getElementById("loader").style.display = "none"; 
              $('div.overlay').removeClass('background-load');
            }
        });
    }
</script>
<div class="container" id="isiform">
    <div class="row justify-content-center">
        <div class="col-md-8 py-4">
          <div id="pesan">
            
          </div>
            <div class="card">
                <div class="card-header">Coupon Management</div>

                <div class="card-body">
                    <form>
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-md-2">
                                <a class="btn btn-primary" href="{{url('/coupon/create')}}">Tambah</a>    
                            </div>
                            
                            <div class="col-md-6 offset-md-4 row">
                                <button type="button" class="btn btn-primary" style="margin-left: 10px;" onclick="cari()"> Cari </button>
                                <input type="text" class="form-control col-md-9" name="search" id="search" placeholder="Masukkan kode kupon..." style="margin-left: 20px;">
                            </div>
                        </div>
                    </form>
                    
                    <div class="tabel">
                        <table class="table table-striped table-bordered" id="tabel">
                            <thead style="text-align: center;">
                                <tr>
                                    <th>Kode Kupon</th>
                                    <th>Diskon</th>
                                    <th>Tipe Kupon</th>
                                    <th colspan="2">Edit</th>
                                </tr>
                            </thead>

                            <tbody id="tabelkupon">
                                @foreach ($coupons as $coupon)
                                    <tr>
                                        <td>{{ $coupon->kodekupon }}</td>
                                        <td>{{ $coupon->diskon }}</td>
                                        <td>{{ $coupon->tipekupon }}</td>
                                        <td align="center"><form action="{{ url('/coupon/'.$coupon->id.'/edit') }}"><button class="btn btn-primary">Update</form></td>
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

<div class="overlay">
  <div id="loader" style="display: none;">
  </div>  
</div>
@endsection