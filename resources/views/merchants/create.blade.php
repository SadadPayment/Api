@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h2>Add Merchants</h2>
@stop

@section('content')
    <div class="panel success">

        <div class="panel-body">
            <form method="post" action="{{url('merchants')}}">
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
                        <label for="type">Type: </label>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" name="type">
                            @foreach($types as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-offset-4">
                        <input type="submit" class="btn btn-success" value="Create">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection