@extends('layouts.app')

@section('content')
<script type="text/javascript">
    function cari(){
        $.ajax({
            type : 'GET',
            url : "{{url('/manage-user/search')}}",
            data : $('form').serialize(),
            dataType : 'json',
            success: function(data) {
                if(document.getElementById('search').value != "") {
                    console.log(data.status=="not-found");
                    if(data.status=="not-found"){
                        console.log("failed");
                        $('#tabeluser').empty();
                    } else {
                        console.log("success");
                        $('#tabeluser').empty();

                        var trHTML = '';
                        trHTML += '<tr><td>' + data.isi.id + '</td><td>' + data.isi.name + '</td><td>' + data.isi.email + '</td><td>' + data.isi.spend_month + '</td><td>' + data.isi.deposit + '</td><td align="center"><form action="<?php echo url('/report'); ?>' +'/'+ data.isi.id +'"> @csrf<button type="submit" class="btn btn-primary">Upload</button></form></td><td align="center"><form action="<?php echo url('/manage-user/login'); ?>' +'/'+ data.isi.id +'" method="post"> @csrf<button type="submit" class="btn btn-primary">Login</button></form></td></tr>';

                        document.getElementById("tabeluser").innerHTML = trHTML;;
                        console.log(trHTML);
                    }
                }
            }
        });
    }
</script>
<div class="container py-4" id="isiform">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">User Management</div>

                <div class="card-body">
                    <form>
                        <div class="form-group row">
                            <input type="text" class="form-control col-md-4" name="search" id="search" placeholder="Masukkan email/nama user..." style="margin-left: 14px;">
                            <button type="button" class="btn btn-primary" style="margin-left:10px;" onclick="cari()"> Cari </button>
                        </div>  
                    </form>

                    <table class="table table-striped table-bordered">
                        <thead align="center">
                            <th>User ID</th>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Max Spend</th>
                            <th>Deposit</th>
                            <th>Report</th>
                            <th>Login</th>
                        </thead>
                        <tbody id="tabeluser">
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>Rp. <?php echo number_format($user->spend_month) ?></td>
                                <td>Rp. <?php echo number_format($user->deposit) ?></td>
                                <td align="center">
                                  <form action="{{url('/report/'.$user->id)}}"> @csrf
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                  </form>
                                </td>
                                <td align="center">
                                  <form action="{{url('/manage-user/login/'.$user->id)}}" method="post"> @csrf
                                    <button type="submit" class="btn btn-primary">Login</button>
                                  </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <?php echo $users->render(); ?> 
                </div>       
            </div>
        </div>
    </div>
</div>
@endsection