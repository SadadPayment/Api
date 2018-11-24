@extends('adminlte::page')

@section('title', 'SADAD Cp')

@section('content_header')
    <h2> Add New Service
    </h2>
@stop

@section('content')
    <div class="panel success" style="
    background-color: #605ca8;">
        <div class="panel-body">
            <form method="post" action="{{url('services')}}">
                @csrf
                <div class="row form-group">
                    <div class="col-md-2">
                        <label for="name">Name: </label>
                    </div>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="name">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <label for="type">Merchant: </label>
                    </div>
                    <div class="col-md-5">
                        <select class="form-control" name="merchant">
                            @foreach($merchants as $merchant)
                                <option value="{{$merchant->id}}">{{$merchant->merchant_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-2">
                        <label for="type">Type: </label>
                    </div>
                    <div class="col-md-5">
                        <select class="form-control" name="type">
                            @foreach($types as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-2">
                        <label for="name">Stander Fees: </label>
                    </div>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="standardFess">
                    </div>
                </div>


                <div class="row form-group">
                    <div class="col-md-2">
                        <label for="name">Sadad Fees: </label>
                    </div>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="sadadFess">
                    </div>

                    <div class="col-md-offset-4">
                        <input type="submit" class="btn btn-success" value="Create">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection