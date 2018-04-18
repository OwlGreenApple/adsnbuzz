@extends('layouts.app')

@section('content')
@guest
@else
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Order</div>

                <div class="card-body">
                    <form action="{{url('/order/'.Auth::user()->id)}}" method="post">
                    	@csrf
                        <div class="form-group row">
                            <label for="jml_order" class="col-sm-4 text-md-right"> Jumlah Order </label>
                            <select class="form-control col-md-4" name="jml_order">
        						<option>5 juta</option>
						        <option>10 juta</option>
						        <option>15 juta</option>
						        <option>20 juta</option>
						        <option>25 juta</option>
						        <option>50 juta</option>
						        <option>100 juta</option>
      						</select>
                        </div>
                

                        <div class="form-group row">
                            <label for="opsibayar" class="col-md-4 col-form-label text-md-right"> Opsi Pembayaran </label>
                            <select class="form-control col-md-4" name="opsibayar">
        						<option>Transfer Bank</option>
						        <option>Credit Card</option>
      						</select>  
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary"> Order </button>
                            </div>
                        </div>

                    </form>
                </div>       
            </div>
        </div>
    </div>
</div>
@endguest
@endsection