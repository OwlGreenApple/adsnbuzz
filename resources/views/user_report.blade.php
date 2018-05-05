@extends('layouts.app')

@section('content')
<script type="text/javascript">
    function viewData(){
    $.ajax({
        type : 'POST',
        url : "{{url('/report-user/'.Auth::user()->id)}}",
        data : $('form').serialize(),
        dataType : 'json',
        success: function(data) {
            if(data.status=='found'){
                console.log("success");
                //$('#isidata').html(data.isi[1].cost); 
                //$('#isidata tbody').html(data.isi[1].cost);
                 $('#isidata tbody').empty();

                var trHTML = '';
                $.each(data.isi, function (i, item) {
                    trHTML += '<tr><td>' + item.report_starts + '</td><td>' + item.report_ends + '</td><td>' + item.campaignname + 
                    '</td><td>' + item.results + '</td><td>' + item.result_ind + '</td><td>' + item.reach + '</td><td>' + item.impressions + '</td><td>' + item.cost + '</td><td>' + item.amountspent + '</td><td>' + item.pta + '</td></tr>';
                });
                $('#isidata tbody').append(trHTML);
            } else {
                console.log("notfound");
                $('#isidata tbody').empty();
            }
            
        }
    });
}
</script>
<div class="container">
    <div class="row" style="margin-bottom: 20px;">
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
    
    <div class="row" id="isidata" style="overflow-x: auto;">
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th>Start</th>
                    <th>End</th>
                    <th>Campaign Name</th>
                    <th>Result</th>
                    <th>Result Indicator</th>
                    <th>Reach</th>
                    <th>Impression</th>
                    <th>Cost per Result</th>
                    <th>Amount Spent</th>
                    <th>People Taking Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection