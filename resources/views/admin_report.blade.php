@extends('layouts.app')

@section('content')
<div class="container py-4" id="isiform">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Report</div>

                <div class="card-body">
                    <form action="{{url('/report/save')}}" method="post" enctype="multipart/form-data">
                    	@csrf
                        <div class="form-group row">
                            <label for="listuser" class="col-md-4 text-md-right"> User </label>
                            <input type="text" name="username" value="{{$user->name}}" disabled>
                            <input type="hidden" name="userid" value="{{$user->id}}">
							</select>
                        </div>
                
                        <div class="form-group row">
                            <label for="file" class="col-md-4 col-form-label text-md-right"> File CSV </label>
                            <input type="file" name="filecsv">  
                        </div>

                        <div class="form-group row">
                            <label for="file" class="col-md-4 col-form-label text-md-right"> Agency Fee </label>
                            <input type="text" class="form-control col-md-1" name="agencyfee" value="20">
                            <p class="col-md-1">%</p>
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