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
          if(data.status=="not-found"){
            console.log("failed");
            $('#tabeluser').empty();
            document.getElementById("pesan").innerHTML = '<div class="alert alert-warning"><strong>Warning!</strong> User tidak ditemukan. </div>';
          } else {
            console.log("success");
            $('#tabeluser').empty();
            document.getElementById("pesan").innerHTML = '';

            var trHTML = '';
            $.each(data.isi, function (i, item) {
              trHTML += '<tr><td>' + item.id + '</td><td>' + item.name + '</td><td>' + item.email + '</td><td>' + item.spend_month + '</td><td>' + item.deposit + '</td><td align="center"><form action="<?php echo url('/report'); ?>' +'/'+ item.id +'"> @csrf<button type="submit" class="btn btn-primary">Upload</button></form></td><td><form action="<?php echo url('/viewreport'); ?>' +'/'+ item.id +'"> @csrf <button type="submit" class="btn btn-primary">View</button></form></td><td align="center"><form action="<?php echo url('/manage-user/login'); ?>' +'/'+ item.id +'" method="post"> @csrf<button type="submit" class="btn btn-primary">Login</button></form></td></tr>';
            });
            document.getElementById("tabeluser").innerHTML = trHTML;;
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

  $(document).ready(function() 
    { 
      $("#myTable").DataTable(); 
    } 
  ); 
</script>

<div class="container py-4" id="isiform">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <!-- Error message -->
      <div id="pesan"> </div>
      <!-- Content -->
      <div class="card">
        <div class="card-header">User Management</div>

        <div class="card-body">
          <form>
            <div class="form-group row">
              <input type="text" class="form-control col-md-4" name="search" id="search" placeholder="Masukkan email/nama user..." style="margin-left: 14px;">
              <button type="button" class="btn btn-primary" style="margin-left:10px;" onclick="cari()"> Cari </button>
            </div>  
          </form>

          <table class="table table-striped table-bordered" id="myTable">
            <thead align="center">
              <th>User ID</th>
              <th>Name</th>
              <th>E-mail</th>
              <th>Max Spend</th>
              <th>Deposit</th>
              <th colspan="2">Report</th>
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
                    <form action="{{url('/report/'.$user->id)}}"> 
                      @csrf
                      <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                  </td>
                  <td>
                    <form action="{{url('/viewreport/'.$user->id)}}"> 
                      @csrf
                      <button type="submit" class="btn btn-primary">View</button>
                    </form>
                  </td>
                  <td align="center">
                    <form action="{{url('/manage-user/login/'.$user->id)}}" method="post"> 
                      @csrf
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

<!-- Loading Bar -->
<div class="overlay">
  <div id="loader" style="display: none;">
  </div>  
</div>
@endsection