@extends('layouts.app')

@section('content')
<script type="text/javascript">
    function viewData(){
    $.ajax({
        type : 'POST',
        url : "{{url('/report-user/'.Auth::user()->id)}}",
        data : $('form').serialize(),
        dataType : 'text',
        success: function(response) {
            console.log("success");
            var data = jQuery.parseJSON(response);

            if(data.type=='found') {
                console.log("success");
                $('#isidata').html(data.value);
            }
            else if(data.type=='not-found') {
                console.log("notfound");
            }
        }
    });
}
</script>
<div class="container" id="isiform">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Report</div>

                <div class="card-body">
                    <form class="form-inline" method="post">
                    	@csrf
                        <div class="form-group">
                            <label for="tgl"> Tanggal </label>
                            <input type="date" class="form-control" name="tglmulai">
                        </div>

                        <div class="form-group">
                            <p>s/d</p>
                            <input type="date" class="form-control" name="tglakhir">
                        </div>
                        
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" onclick="viewData()"> Lihat </button>
                        </div>
                    </form>

                    <div id="isidata">
                        
                    </div>
                </div>       
            </div>
        </div>
    </div>
</div>
@endsection