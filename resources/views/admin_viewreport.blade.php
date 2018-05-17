@extends('layouts.app')

@section('content')
<script type="text/javascript">
  function replacenull(item){
    if (item==null){
      return "-";
    } else {
      return item;
    }
  }

  function deleteData(id,row){
    if(confirm("Are you sure want to delete?")) {
      $.ajax({
        type : 'DELETE',
        url : "<?php echo url('/deletereport'); ?>"+'/'+id,
        data: { "_token": "{{ csrf_token() }}" },
        //dataType : 'text',
        success: function(response) {
          console.log("success");
          document.getElementById("pesan").innerHTML = '<div class="alert alert-success"><strong>Success!</strong> Report berhasil dihapus. </div>';

          var el = row.parentNode.parentNode.rowIndex;
          document.getElementById("tabel").deleteRow(el);
        }
      });
    }
  }

  function viewData(){
    $.ajax({
      type : 'POST',
      url : "{{url('/viewreport/view/'.$user->id)}}",
      data : $('form').serialize(),
      dataType : 'json',
      success: function(data) {
        if(data.status=='found'){
          console.log("success");
          //$('#isidata').html(data.isi[1].cost); 
          //$('#isidata tbody').html(data.isi[1].cost);
          $('#isidata').empty();

          var trHTML = '';
          $.each(data.isi, function (i, item) {
            trHTML += '<tr><td>'+item.report_starts+'</td><td>'+item.report_ends+'</td><td>'+replacenull(item.campaignname)+'</td><td>'+replacenull(item.results)+'</td><td>'+replacenull(item.result_ind)+'</td><td>'+replacenull(item.reach)+'</td><td style="width:100px;">'+replacenull(item.impressions)+'</td><td>'+replacenull(item.cost)+'</td><td>'+replacenull(item.amountspent)+'</td><td>'+replacenull(item.pta)+'</td><td><button class="btn btn-danger" onclick="deleteData('+ item.id +',this)" >Delete</button></td></tr>';
          });
          document.getElementById("isidata").innerHTML = trHTML;
          document.getElementById("pesan").innerHTML = '';
        } else {
          console.log("notfound");
          document.getElementById("pesan").innerHTML = '<div class="alert alert-warning"><strong>Warning!</strong> Data report tidak ditemukan. </div>'
          $('#isidata').empty();
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
      $('div.overlay').removeClass('background-load');
      //nyamain thead sama tbody
      var $table = $('table'),
      $bodyCells = $table.find('tbody tr:first').children(), colWidth;

      $(window).resize(function() {
        // Get the tbody columns width array
        colWidth = $bodyCells.map(function() {
          return $(this).width();
        }).get();
              
        // Set the width of thead columns
        $table.find('thead tr').children().each(function(i, v) {
          $(v).width(colWidth[i]);
        });  
      }).resize(); // Trigger resize handler
    }
  });
</script>

<style type="text/css">
  thead, tbody { display: block; }

  tbody {
      height: 250px;       
      overflow-y: auto;    
      overflow-x: hidden;  
  }
  td {
    min-width:88px;
    max-width:150px;
  }
</style>

<div align="center">
  <div class="col-md-11 py-4">
    <div id="pesan" align="left"> </div>
      
    <div class="card">
      <div class="card-header" align="left"> View Report </div>

      <div class="card-body">
        <div class="row col-md-12" style="margin-left: 10px; margin-bottom: 20px; ">
          <form class="form-inline" method="post">
            @csrf
            <div class="form-group">
              <label for="tgl"> Tanggal </label>
              <div class="col-md-1">
                <input type="date" class="form-control" name="tglmulai">
              </div>
            </div>

            <div class="form-group">
              <label>s/d</label>
              <div class="col-md-1">
                <input type="date" class="form-control" name="tglakhir">
              </div>
            </div>
                                              
            <div class="form-group">
              <button type="button" class="btn btn-primary" onclick="viewData()"> Lihat </button>
            </div>
          </form>    
        </div> 

        <div class="row col-md-12" style="margin-left: 10px;">
          <table class="table table-bordered table-striped table-responsive" id="tabel">
            <thead>
              <th>Starts</th>
              <th>Ends</th>
              <th>Campaign Name</th>
              <th>Result</th>
              <th>Result Indicator</th>
              <th>Reach</th>
              <th>Impression</th>
              <th>Cost per Result</th>
              <th>Amount spent</th>
              <th style="width:261px;">People Taking Action</th>
              <th>Delete</th>
            </thead>
            <tbody id="isidata"> </tbody>
          </table>
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