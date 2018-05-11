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
                    success: function(response) {
                        console.log("success");
                        alert("Kupon berhasil dihapus");
                        
                        var el = row.parentNode.parentNode.rowIndex;
                        document.getElementById("tabelkupon").deleteRow(el);
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
            success: function(data) {
                if(document.getElementById('search').value != "") {
                    console.log(data.status=="not-found");
                    if(data.status=="not-found"){
                        console.log("failed");
                        $('#tabelkupon').empty();
                    } else {
                        console.log("success");
                        $('#tabelkupon').empty();

                        var trHTML = '';
                        trHTML += '<tr><td>' + data.isi.kodekupon + '</td><td>' + data.isi.diskon + '</td><td>' + data.isi.tipekupon + '</td><td align="center"><form action="<?php echo url('/coupon'); ?>' +'/'+ data.isi.id +'/edit"><button class="btn btn-primary">Update</form></td><td align="center"><button class="btn btn-danger" onclick="deleteData('+ data.isi.id +',this)">Delete</td></tr>';

                        document.getElementById("tabelkupon").innerHTML = trHTML;;
                        console.log(trHTML);
                    }
                }
            }
        });
    }
</script>
<div class="container" id="isiform">
    <div class="row justify-content-center">
        <div class="col-md-8 py-4">
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
                        <table class="table table-striped table-bordered">
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
@endsection