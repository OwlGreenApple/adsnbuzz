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
                        $("#pesan").addClass("alert alert-success alert-dismissible");
                        $("#pesan").append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
                        $('#pesan').html("Kupon berhasil dihapus.");
                        
                        var el = row.parentNode.parentNode.rowIndex;
                        document.getElementById("tabelkupon").deleteRow(el);
                    }
            });
        }
    }
</script>
<div class="container" id="isiform">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Coupon Management</div>

                <div class="card-body">
                    <div class="tomboltambah" style="margin-bottom: 20px;">
                        <a class="btn btn-primary" href="{{url('/coupon/create')}}">Tambah</a>
                    </div>

                    <div class="tabel">
                        <table class="table table-striped table-bordered" id="tabelkupon">
                            <thead style="text-align: center;">
                                <tr>
                                    <th>Kode Kupon</th>
                                    <th>Diskon</th>
                                    <th>Tipe Diskon</th>
                                    <th colspan="2">Edit</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($coupons as $coupon)
                                    <tr>
                                        <td>{{ $coupon->kodekupon }}</td>
                                        <td>{{ $coupon->diskon }}</td>
                                        <td>{{ $coupon->tipekupon }}</td>
                                        <td align="center"><form action="{{ url('/coupon/'.$coupon->id.'/edit') }}"><button class="btn btn-primary">Update</form></td>
                                        <td align="center"><button class="btn btn-danger" onclick="deleteData({{ $coupon->id }},this)">Delete</form></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>    
                    </div>
                    <?php echo $coupons->render(); ?> 

                    <div id="pesan">
                        
                    </div>
                </div>       
            </div>
        </div>
    </div>
</div>
@endsection