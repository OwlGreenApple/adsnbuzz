@extends('layouts.app')

@section('content')
<div class="container" id="isiform">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Insert Coupon</div>

                <div class="card-body">
                    <form action="{{url('/coupon/insert')}}" method="post">
                    	@csrf
                        <div class="form-group row">
                            <label for="kodekupon" class="col-md-4 text-md-right"> Kode Kupon </label>
                            <input type="text" class="form-control col-md-4" name="kodekupon">
                        </div>
                        
                        <div class="form-group row">
                            <label for="tipekupon" class="col-md-4 text-md-right"> Tipe Kupon </label>
                            <select class="form-control col-md-4" name="tipekupon">
                            	<option>Nominal</option>
                                <option>Persen</option>
							</select>
                        </div>
                
                        <div class="form-group row">
                            <label for="diskon" class="col-md-4 col-form-label text-md-right"> Diskon </label>
                            <input type="text" class="form-control col-md-4" name="diskon">
                        </div>

                        <div class="form-group" align="center">
                            <button type="submit" class="btn btn-primary"> Tambah </button>
                        </div>
                    </form>
                </div>       
            </div>
        </div>
    </div>
</div>
@endsection