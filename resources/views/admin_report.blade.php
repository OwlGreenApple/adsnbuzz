@extends('layouts.app')

@section('content')
<script type="text/javascript">
    function saveData(){
        $.ajax({
        type : 'POST',
        url : "{{url('/report/save'}}",
        data : $('form').serialize(),
        dataType : 'text',
        success: function(response) {
            console.log("success");
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
                    <form action="{{url('/report/save'}}">
                    	@csrf
                        <div class="form-group row">
                            <label for="listuser" class="col-md-4 text-md-right"> User </label>
                            <select class="form-control col-md-4" name="listuser">
                            	@foreach($users as $user)
                            		<option>{{$user->name}}</option>
                            	@endforeach
							</select>
                        </div>
                
                        <div class="form-group row">
                            <label for="filecsv" class="col-md-4 col-form-label text-md-right"> File CSV </label>
                            <input type="file">  
                        </div>

                        <div class="form-group" align="center">
                            <button type="submit" class="btn btn-primary"> Upload </button>
                        </div>
                    </form>
                </div>       
            </div>
        </div>
    </div>
</div>
@endsection