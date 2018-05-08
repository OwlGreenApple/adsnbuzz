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
                    trHTML += '<tr><th>Start</th><td>'+item.report_starts+'</td></tr><tr><th>End</th><td>'+item.report_ends+'</td></tr><tr><th>Campaign Name</th><td>'+replacenull(item.campaignname)+'</td></tr><tr><th>Result</th><td>'+replacenull(item.results)+'</td></tr><tr><th>Result Indicator</th><td>'+replacenull(item.result_ind)+'</td></tr><tr><th>Reach</th><td>'+replacenull(item.reach)+'</td></tr><tr><th>Impression</th><td>'+replacenull(item.impressions)+'</td></tr><tr><th>Cost per Result</th><td>'+replacenull(item.cost)+'</td></tr><tr><th>Amount Spent</th><td>'+replacenull(item.amountspent)+'</td></tr><tr><th>People Taking Action</th><td>'+replacenull(item.pta)+'</td></tr><tr style="height:30px;"></tr>';
                });
                document.getElementById("isidata").innerHTML = trHTML;
            } else {
                console.log("notfound");
                $('#isidata tbody').empty();
            }
            
        }
    });
}
</script>

<style type="text/css">
    thead, tbody { display: block; }

    tbody {
        height: 380px;       /* Just for the demo          */
        overflow-y: auto;    /* Trigger vertical scroll    */
        overflow-x: auto;  /* Hide the horizontal scroll */
    }

    th {
        background-color: #193642;
        color:white;
    }

    td {
        width: 350px;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="daftarmenu col-md-3">
            @include('layouts.user')
        </div>

        <div class="kontenmenu col-md-9 py-4" id="isiform">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header"> Report </div>

                    <div class="card-body">
                        <div class="row col-md-10" style="margin-left: 10px; margin-bottom: 20px; ">
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

                        <div class="row col-md-10" style="margin-left: 10px;">
                            <table class="table table-bordered table-striped table-responsive" id="isidata">
                                <tr>
                                    <th>Start</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>End</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Campaign Name</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Result</th>
                                    <td></td>
                                </tr>    
                                <tr>
                                    <th>Result Indicator</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Reach</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Impression</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Cost per Result</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Amount Spent</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>People Taking Action</th>
                                    <td></td>
                                </tr>
                            </table>
                        </div>        
                    </div>
                </div>    
            </div>
        </div>  
    </div>  
</div>
@endsection